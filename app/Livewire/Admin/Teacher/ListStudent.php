<?php

namespace App\Livewire\Admin\Teacher;

use Filament\Tables;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListStudent extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Section $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->columns([
                TextColumn::make('user')->formatStateUsing(function ($state) {
                    return $state->getFullName();
                })
                    ->label('Student Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                       }),

                       TextColumn::make('user.email')
                       ->label('Email')
                       ->searchable(),

                       ToggleColumn::make('is_approved')
                       ->onColor('success')
                       ->offColor('danger')

                    ->afterStateUpdated(function ($record, $state) {
                        $message  = "Rejected";
                        if($state){
                            $message  = "Approved";
                        }else{
                            $message  = "Rejected";
                        }
                        Notification::make()
                        ->title($message)
                        ->success()
                        ->send();
                        // Runs after the state is saved to the database.
                    })

            //    TextColumn::make('enrolled_section.section.title')
            //         ->numeric()
            //         ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                
                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Details')
                        ->modalContent(function (Student $record) {
                            return view('livewire.users.user-details', ['record' => $record->user]);
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        ->disabledForm()
                        ->slideOver()
                        ->modalWidth(MaxWidth::SevenExtraLarge),





                            // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),


                    DeleteAction::make('delete'),
                    ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('enrolled_section.section', function($query){
                $query->where('id',$this->record->id);
            }))
            ;
    }

    public function render(): View
    {
        return view('livewire.admin.teacher.list-student');
    }
}
