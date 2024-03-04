<?php

namespace App\Livewire\Excercises;

use Filament\Tables;
use App\Models\Lesson;
use Livewire\Component;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListExcercises extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Excercise::query())
            ->columns([
                // Tables\Columns\TextColumn::make('exerciseable_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('exerciseable_type')
                //     ->searchable(),
              TextColumn::make('title')
                    ->searchable(),
              TextColumn::make('type')
                    ->searchable(),

                    Tables\Columns\TextColumn::make('questions_count')->counts('questions')->label('Number of Questions'),
    //                 TextColumn::make('questions.content')
    // ->listWithLineBreaks()
    // ->bulleted()
                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('created_by')
                //     ->searchable(),
                // Tables\Columns\IconColumn::make('is_lock')
                //     ->boolean(),
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
                    ->successNotificationTitle('Excercise Created')
                    ->label('New Excercise')
                    ->icon('heroicon-m-sparkles')

                    ->form([

                        Section::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([


                                TextInput::make('title')->required()->columnSpan(4),
                                Select::make('type')
                                    ->options([
                                        'Multiple Choice' => 'Multiple Choice',
                                        'True or False' => 'True or False',
                                        'Fill in the Blankr' => 'Fill in the Blank',
                                    ])
                                    ->required()
                                    ->columnSpan(4),




                                RichEditor::make('description')

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
                                    ->required()
                                    ->columnSpanFull(),




                                        

                                // FileUpload::make('image_path')
                                //     ->disk('public')
                                //     ->directory('chapters-images')
                                //     ->image()
                                //     // ->required()
                                //     ->label('Display Image')


                                //     ->columnSpanFull()

                            ]),




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])
                    ->closeModalByClickingAway(false)
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ->slideOver()
                    ->disableCreateAnother(),
            ])
            ->actions([
                Action::make('Manage Questions')
                ->color('primary')
                ->icon('heroicon-m-cursor-arrow-rays')
                ->label('Manage Questions')
                ->url(function (Model $record) {
                    // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                    return route('manage-excercise-questions', ['record' => $record]);
                }),

                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Excercise')
                        //  ->url(fn (Model $record): string => route('manage-excercise-questions', ['record' => $record])),
                        ->modalContent(function (Excercise $record) {
                            return view('livewire.excercises.exercise-details', ['record' => $record]);
                        })
                        ->modalWidth(MaxWidth::SevenExtraLarge)
                        ->modalSubmitAction(false)
                        ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        ->disabledForm()
                        ->slideOver()
                        ->closeModalByClickingAway(false),

                    EditAction::make('edit')
                        ->successNotificationTitle('Lesson updated')
                        ->color('primary')

                        ->form([


                        Section::make()
                        ->columns([
                            'sm' => 3,
                            'xl' => 6,
                            '2xl' => 8,
                        ])
                        ->schema([


                            TextInput::make('title')->required()->columnSpan(4),
                            Select::make('type')
                                ->options([
                                    'Multiple Choice' => 'Multiple Choice',
                                    'True or False' => 'True or False',
                                    'Fill in the Blankr' => 'Fill in the Blank',
                                ])
                                ->required()
                                ->columnSpan(4),




                            RichEditor::make('description')

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
                                ->required()
                                ->columnSpanFull(),







                        ]),


                        ])
                        ->modalWidth(MaxWidth::SevenExtraLarge)
                        ->slideOver(),
                    DeleteAction::make('delete'),
                ]),
                //
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
        return view('livewire.excercises.list-excercises');
    }
}
