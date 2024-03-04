<?php

namespace App\Livewire\Exercises;

use Filament\Tables;
use Livewire\Component;
use App\Models\Question;
use App\Models\Excercise;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class ListQuestions extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public Excercise $record;
    public function table(Table $table): Table
    {
        return $table
            ->query(Question::query())
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question_number.number')
                    ->label('Questions')

                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()
                    ->successNotificationTitle('Question Created')
                    ->label('New Question')
                    ->icon('heroicon-m-sparkles')

                    ->mutateFormDataUsing(function (array $data): array {
                        $data['excercise_id'] = $this->record->id;



                        return $data;
                    })

                    ->form(
                        [


                            Section::make()
                                ->columns([
                                    'sm' => 8,
                                    'md' => 8,
                                    'xl' => 8,
                                    '2xl' => 8,
                                ])
                                ->schema([




                                    TextInput::make('question')
                                        ->label('Type Your Question')

                                        ->columnSpan(6),

                                    Select::make('question_number_id')
                                        ->relationship(
                                            name: 'question_number',
                                            titleAttribute: 'number',
                                            modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('questions.excercise', function ($query) {
                                                $query->where('id', $this->record->id);
                                            })
                                        )

                                        ->preload()
                                        ->columnSpan(2)
                                        ->searchable()
                                        ->required(),


                                    Group::make()
                                        ->relationship('multiple_choice_question')
                                        ->columns([
                                            'sm' => 8,
                                            'md' => 8,
                                            'xl' => 8,
                                            '2xl' => 8,
                                        ])
                                        ->schema([

                                            TableRepeater::make('options')
                                            ->label('Set Options')
                                                ->schema([
                                                    TextInput::make('option')->required()->columnSpanFull(),
                                                ])
                                                ->reorderable(false)
                                                ->deletable(false)
                                                ->withoutHeader()
                                                ->emptyLabel('No Options')
                                                // ->addable(false)
                                                ->minItems(3)
                                                ->maxItems(3)
                                                ->columnSpanFull(),
                                            TextInput::make('correct_answer')
                                                ->label('Correct Answer')
                                                ->required(),

                                        ])->columnSpanFull(),



                                ]),




                        ]
                    )
                    ->closeModalByClickingAway(false)
                    ->modalWidth(MaxWidth::Full)
                    ->slideOver()
                    ->disableCreateAnother(),
            ])
            ->actions([

                Action::make('view')
                    ->color('primary')
                    ->button()->outlined()
                    ->icon('heroicon-m-eye')
                    ->label('View ')
                    ->url(fn (Model $record): string => route('view-question-details', ['record' => $record])),
                    // ->modalContent(function (Question $record) {
                    //     return view('livewire.questions.question-details', ['record' => $record]);
                    // })
                    // ->modalWidth(MaxWidth::Full)
                    // ->modalSubmitAction(false)
                    // ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                    // ->disabledForm()
                    // ->slideOver()
                    // ->closeModalByClickingAway(false),

                EditAction::make('edit')
                    ->successNotificationTitle('Question updated')
                    ->color('primary')
                    ->mutateRecordDataUsing(function (array $data): array {




                        return $data;
                    })
                    ->form([



                        Section::make()
                            ->columns([
                                'sm' => 8,
                                'md' => 8,
                                'xl' => 8,
                                '2xl' => 8,
                            ])
                            ->schema([




                                TextInput::make('question')
                                    ->label('Question')

                                    // ])
                                    ->columnSpan(6),

                                Select::make('question_number_id')
                                    ->relationship(
                                        name: 'question_number',
                                        titleAttribute: 'number',
                                        modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('questions.excercise', function ($query) {
                                            $query->where('id', $this->record->id);
                                        })
                                    )

                                    ->preload()
                                    ->columnSpan(2)
                                    ->searchable()
                                    ->required(),



                            ]),

                    ])
                    ->button()->outlined()
                    ->modalWidth(MaxWidth::Full)
                    ->slideOver(),
                DeleteAction::make('delete')->button()->outlined(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                    ->label('Actions'),
            ])

            ->modifyQueryUsing(fn (Builder $query) => $query->where('excercise_id', $this->record->id)->join('question_numbers', 'questions.question_number_id', '=', 'question_numbers.id')
                ->orderBy('question_numbers.number', 'asc'));
    }

    public function render(): View
    {
        return view('livewire.exercises.list-questions');
    }
}
