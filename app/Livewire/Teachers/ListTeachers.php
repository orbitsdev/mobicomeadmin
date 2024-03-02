<?php

namespace App\Livewire\Teachers;

use Filament\Tables;
use App\Models\Teacher;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListTeachers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Teacher::query())
            ->columns([
                TextColumn::make('user')->formatStateUsing(function ($state) {
                    return $state->getFullName();
                })
                ->label('Name')
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('user', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                }),


            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()

                    ->icon('heroicon-m-academic-cap')
                    ->form([


                        Section::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([


                                Select::make('user_id')
                                    ->label('Select Account')
                                    ->relationship(
                                        name: 'user',
                                        titleAttribute: 'last_name',
                                        modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('teacher'),
                                    )
                                    ->required()

                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => $record->getFullName())
                                    ->searchable(['first_name', 'last_name'])
                                    ->preload()
                                    ->searchable()
                                    ->columnSpanFull(),

                            ]),




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])
                    // ->slideOver()
                    ->disableCreateAnother(),
            ])

            ->actions([
                ActionGroup::make([
                    Action::make('view')
                    ->color('primary')
                    ->icon('heroicon-m-eye')
                    ->label('View Details')
                    ->modalContent(function (Teacher $record) {
                        return view('livewire.users.user-details', ['record' => $record->user]);
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                    ->disabledForm()
                    ->slideOver(),

                    EditAction::make()
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ->color('primary')
                    ->form([
                      
                        Section::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([
    
    
                                Select::make('user_id')
                                
                                    ->label('Select Account')
                                    ->relationship(
                                        name: 'user',
                                     
                                        modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('teacher'),
                                    )
    
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}")
                                    ->searchable(['first_name', 'last_name'])
                                    ->preload()
                                        ->required()
                                    ->searchable()
                                    
                                    ->columnSpanFull(),
    
                            ]),
    
    
    
    
                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                        ]),
                    DeleteAction::make('delete'),
                ]),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                ->label('Actions')
                ,
            ])
            

            ;
    }

    public function render(): View
    {
        return view('livewire.teachers.list-teachers');
    }
}
