<?php

namespace App\Livewire\Students;

use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Get;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use App\Models\Section as MSection;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
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
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListStudents extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

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
                   TextColumn::make('user.email')->searchable()->label('Email'),

                    TextColumn::make('enrolled_section.teacher.user')
                    ->formatStateUsing(function($state){
                        return $state->getFullName();
                    })
                    ->label('Teacher')
                    ->badge(),
                    TextColumn::make('enrolled_section.section.title')
                        ->label('Section')
                        ->badge()
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
                // Filter::make('section')
                // ->form([
                //     Select::make('section_id')
                //         ->options(MSection::whereHas('handled_sections')->pluck('title','id'))
                //         ->label('Card Availabilty')
                //         ->selectablePlaceholder(false)
                // ])
                // ->query(function (Builder $query, array $data): Builder {
                //     return $query->whereHas('handled_section',function($query) use($data){
                //         $query->where('section_id', $data['section_id']);
                //     });
                // })


                SelectFilter::make('sections')
                ->options(fn() => MSection::whereHas('enrolled_sections')->pluck('title', 'id')) //you probably want to limit this in some way?
                ->modifyQueryUsing(function (Builder $query, $state) {
                    if (! $state['value']) {
                        return $query;
                    }
                    return $query->whereHas('enrolled_section', fn($query) => $query->where('section_id', $state['value']));
                }),

            ],
            layout: FiltersLayout::AboveContent
            )

            ->headerActions([

                CreateAction::make()
                ->successNotificationTitle('Student Created')
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

                                Select::make('enrolled_section_id')
                                    ->label('Select Section')
                                    ->relationship(
                                        name: 'enrolled_section',
                                        titleAttribute: 'created_at',

                                    )
                                    ->getOptionLabelFromRecordUsing(fn (Model $record) => $record->section->title)
                                    ->preload()
                                    ->required()
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
                ->label('View Profile')

                ->button()
                ->outlined()
                ->url(function(Student $record){
                    return route('student-profile',['record'=> $record]);
                }),
                ActionGroup::make([

                        // ->modalContent(function (Student $record) {
                        //     return view('livewire.users.user-details', ['record' => $record->user]);
                        // })
                        // ->modalSubmitAction(false)
                        // ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        // ->disabledForm()
                        // ->slideOver(),

                    // EditAction::make()
                    //     ->modalWidth(MaxWidth::SevenExtraLarge)
                    //     ->color('primary')
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
                    //                         titleAttribute: 'last_name',
                    //                         modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('teacher')->whereDoesntHave('student'),
                    //                     )
                    //                     ->required()

                    //                     ->getOptionLabelFromRecordUsing(fn ($record) => $record->getFullName() . ' - ' . $record->email)
                    //                     ->searchable(['first_name', 'last_name', 'email'])
                    //                     ->preload()
                    //                     ->searchable()
                    //                     ->columnSpanFull(),

                    //                 Select::make('section_id')
                    //                     ->label('Select Section')
                    //                     ->relationship(
                    //                         name: 'section',
                    //                         titleAttribute: 'title',

                    //                     )
                    //                     ->required()

                    //                     ->getOptionLabelFromRecordUsing(fn ($record) => $record->title)
                    //                     ->searchable(['title'])
                    //                     ->preload()
                    //                     ->searchable()
                    //                     ->columnSpanFull(),
                    //                 Select::make('teacher_id')
                    //                     ->label('Select Section')
                    //                     ->relationship(
                    //                         name: 'section',
                    //                         titleAttribute: 'title',

                    //                     )
                    //                     ->required()

                    //                     ->getOptionLabelFromRecordUsing(fn ($record) => $record->title)
                    //                     ->searchable(['title'])
                    //                     ->preload()
                    //                     ->searchable()
                    //                     ->columnSpanFull(),

                    //             ]),



                    //         // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    //     ]),
                    DeleteAction::make('delete'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                    ->label('Actions'),
            ])
            ->groups([

                    Group::make('enrolled_section.section.title')
                        ->label('Section')

                    ->titlePrefixedWithLabel(false),

            ])
            ->defaultGroup('enrolled_section.section.title');

            ;
    }

    public function render(): View
    {
        return view('livewire.students.list-students');
    }
}
