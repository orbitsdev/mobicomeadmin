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
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

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
                Tables\Columns\TextColumn::make('excercise.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question_number.number')
                    ->numeric()
                    ->sortable(),
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

                            Select::make('question_number_id')
                                ->relationship(
                                    name: 'question_number',
                                    titleAttribute: 'number',
                                    modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('questions.excercise', function ($query) {
                                        $query->where('id', $this->record->id);
                                    })
                                )

                                ->preload()
                                ->columnSpanFull()
                                ->searchable()
                                ->required(),

                            Section::make()
                                ->columns([
                                    'sm' => 8,
                                    'md' => 8,
                                    'xl' => 8,
                                    '2xl' => 8,
                                ])
                                ->schema([




                                    RichEditor::make('content')

                                        ->toolbarButtons([

                                            'blockquote',
                                            'bold',
                                            'bulletList',
                                            'codeBlock',
                                            'h2',
                                            'h3',
                                            'italic',
                                            'link',
                                            'orderedList',
                                            'redo',
                                            'strike',
                                            'underline',
                                            'undo',
                                        ])
                                        ->columnSpanFull(),


                                ]),




                        ]
                    )
                    ->closeModalByClickingAway(false)
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ->slideOver()
                    ->disableCreateAnother(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Question')
                        // ->url(fn (Model $record): string => route('view-lesson-details', ['record' => $record]))
                        ->modalContent(function (Question $record) {
                            return view('livewire.questions.question-details', ['record' => $record]);
                        })
                        ->modalWidth(MaxWidth::Full)
                        ->modalSubmitAction(false)
                        ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        ->disabledForm()
                        ->slideOver()
                        ->closeModalByClickingAway(false)
                        ,
                 
                    EditAction::make('edit')
                    ->successNotificationTitle('Question updated')
                        ->color('primary')
                        ->mutateRecordDataUsing(function (array $data): array {

                           
                           
                     
                            return $data;
                        })
                        ->form([
                            Select::make('question_number_id')
                            ->relationship(
                                name: 'question_number',
                                titleAttribute: 'number',
                                modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('questions.excercise', function ($query) {
                                    $query->where('id', $this->record->id);
                                })
                            )

                            ->preload()
                            ->columnSpanFull()
                            ->searchable()
                            ->required(),

                        Section::make()
                            ->columns([
                                'sm' => 8,
                                'md' => 8,
                                'xl' => 8,
                                '2xl' => 8,
                            ])
                            ->schema([




                                RichEditor::make('content')

                                    ->toolbarButtons([

                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                                    ->columnSpanFull(),


                            ]),

                        ])
                        ->modalWidth(MaxWidth::SevenExtraLarge)
                        ->slideOver(),
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
            
            ->modifyQueryUsing(fn (Builder $query) => $query->where('excercise_id', $this->record->id)->join('question_numbers', 'questions.question_number_id', '=', 'question_numbers.id')
            ->orderBy('question_numbers.number', 'asc'))
            ;
    }

    public function render(): View
    {
        return view('livewire.exercises.list-questions');
    }
}
