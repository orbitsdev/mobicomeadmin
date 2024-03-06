<?php

namespace App\Livewire\TeacherManagement;

use Filament\Tables;

use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;

use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\Section as FSection;

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
            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()
                ->successNotificationTitle('Student Created')
                ->mutateFormDataUsing(function (array $data): array {
                    $data['enrolled_section_id'] = $this->record->enrolled_section->id;


                    return $data;
                })
                ->icon('heroicon-m-sparkles')

                    ->form([


                        FSection::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([

                                Select::make('user_id')
                                    ->label('Select Student')
                                    ->relationship(
                                        name: 'user',
                                        titleAttribute: 'first_name',
                                        modifyQueryUsing: fn ($query) => $query->where('role', 'Student')->whereDoesntHave('student'),
                                    )
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => $record->getFullName() . ' - ' . $record->email)
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull()
                                    ->searchable(['first_name', 'last_name', 'email']),





                            ]),





                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])
                    // ->slideOver()
                    ->disableCreateAnother(),
            ])
            ->actions([
                
            
                Action::make('view')
                ->color('primary')
                ->label('View Profile')
                
                ->button()
                ->outlined()
                ->url(function(Student $record){
                    return route('view-student',['record'=> $record]);
                })
                // ActionGroup::make([
                //     Action::make('view')
                //     ->color('primary')
    
                //     ->label('View Profile')
                //     ->url(function(Student $record){
                //         return route('view-student',['record'=> $record]);
                //     })
                //         // ->modalContent(function (Student $record) {
                //         //     return view('livewire.users.user-details', ['record' => $record->user]);
                //         // })
                //         // ->modalSubmitAction(false)
                //         // ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                //         // ->disabledForm()
                //         // ->slideOver()
                //         // ->modalWidth(MaxWidth::SevenExtraLarge),





                //             // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),


                //     // DeleteAction::make('delete'),
                //     ])

                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.teacher-management.list-student');
    }
}
