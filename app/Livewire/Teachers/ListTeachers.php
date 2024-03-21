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
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

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

                    TextColumn::make('user.email')->label('Email')->searchable(),

                TextColumn::make('sections_count')->counts('sections'),

                // ToggleColumn::make('is_approved')
                //     ->label('Status')
                //     ->onColor('success')
                //     ->offColor('danger')

                //     ->afterStateUpdated(function ($record, $state) {
                //         $message  = "Not Active";
                //         if ($state) {
                //             $message  = "Active";
                //         } else {
                //             $message  = "Not Active";
                //         }
                //         Notification::make()
                //             ->title($message)
                //             ->success()
                //             ->send();
                //         // Runs after the state is saved to the database.
                //     }),    TextColumn::make('created_at')->date(),


            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()
                    ->successNotificationTitle('Teacher Created')
                    ->icon('heroicon-m-sparkles')

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
                                        modifyQueryUsing: fn (Builder $query) => $query->where('role', 'Teacher')->whereDoesntHave('teacher'),
                                    )
                                    ->required()

                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}  - {$record->email}")
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

                Action::make('view')
                    ->color('primary')
                    ->icon('heroicon-m-eye')
                    ->label('View Profile')
                    ->url(function (Model $record) {
                        return route('view-teacher-profile', ['record' => $record]);
                    })
                    ->button()
                    ->outlined(),

                // ->modalContent(function (Teacher $record) {
                //     return view('livewire.users.user-details', ['record' => $record->user]);
                // })
                // ->modalSubmitAction(false)
                // ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                // ->disabledForm()
                // ->slideOver(),
                ActionGroup::make([


                    EditAction::make('manage')
                        ->successNotificationTitle('Updated Save')
                        ->color('primary')
                        ->icon('heroicon-m-inbox-stack')
                        ->label('Enrolled Sections')
                        // ->url(fn(Model $record)=> route('manage-teacher-sections',['record'=> $record]))

                        ->slideOver()
                        ->form([

                            CheckboxList::make('sections')
                                ->relationship(
                                    name: 'sections',
                                    titleAttribute: 'title'
                                )
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->title}")
                                ->bulkToggleable()
                                ->columns(3)
                                ->gridDirection('row')
                                ->searchable()
                                ->label('Select Handles Sections'),





                        ]),


                    // EditAction::make()
                    //     ->modalWidth(MaxWidth::SevenExtraLarge)
                    //     ->color('primary')
                    //     ->label('Edit Teacher')
                    //     ->form([

                    //         Section::make()
                    //             ->columns([
                    //                 'sm' => 3,
                    //                 'xl' => 6,
                    //                 '2xl' => 8,
                    //             ])
                    //             ->schema([


                    //                 Select::make('user_id')

                    //                     ->label('Select Account')
                    //                     ->relationship(
                    //                         name: 'user',

                    //                         modifyQueryUsing: fn (Builder $query) => $query->where('role', 'Teacher')->whereDoesntHave('teacher'),
                    //                     )

                    //                     ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}  - {$record->email}")
                    //                     ->searchable(['first_name', 'last_name', 'email'])
                    //                     ->preload()
                    //                     ->required()
                    //                     ->searchable()

                    //                     ->columnSpanFull(),

                    //             ]),




                    //     ]),
                    DeleteAction::make('delete')->label('Remove Teacher')->modalHeading('Remove Teacher'),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                    ->label('Actions'),
            ]);
    }

    public function render(): View
    {
        return view('livewire.teachers.list-teachers');
    }
}
