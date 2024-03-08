<?php

namespace App\Livewire\Exercises;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Excercise;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class ManageMultipleChoice extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Excercise $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Questions')

                    ->schema([

                        TableRepeater::make('exercise_questions')
                            ->relationship('questions')
                            ->columnWidths([

                                'question_number_id' => '200px',
                            ])
                            ->label('Set Exercise Questions')
                            ->schema([
                                TextInput::make('question')->required(),


                                Select::make('question_number_id')
                                    ->label('Number')
                                    ->relationship(
                                        name: 'question_number',
                                        titleAttribute: 'number',
                                        modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('questions.excercise', function ($query) {
                                            $query->where('id', $this->record->id);
                                        })
                                    )
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->preload()

                                    ->searchable()
                                    ->required(),

                                Group::make()
                                    ->relationship('multiple_choice')

                                    ->schema([

                                        TableRepeater::make('options')
                                        ->hideLabels()
                                            ->label('Choices')
                                            ->schema([
                                                TextInput::make('option')->required()->columnSpanFull()
                                            ])
                                            ->defaultItems(2)
                                            ->addable(false)
                                            ->deletable(false)
                                            ->reorderable(false)
                                            ->withoutHeader()
                                            ->emptyLabel('No Options')

                                            ->minItems(2)
                                            ->maxItems(2),

                                        TextInput::make('correct_answer')
                                            ->label('Answer')
                                            ->required(),

                                    ])->columnSpanFull(),

                            ])
                            ->defaultItems(3)
                            ->maxItems(50)
                            ->emptyLabel('No question was set in this exercise')
                            ->addActionLabel('Add Question')
                            ->withoutHeader()
                            ->reorderable(false)
                            ->columnSpanFull(),


                    ])
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save()
    {
        $data = $this->form->getState();
        $this->record->update($data);

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
        return redirect()->route('list-excercises');
    }

    public function render(): View
    {
        return view('livewire.exercises.manage-multiple-choice');
    }
}
