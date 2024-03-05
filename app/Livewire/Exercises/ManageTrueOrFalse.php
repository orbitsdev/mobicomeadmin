<?php

namespace App\Livewire\Exercises;

// use App\Models\Exercise;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Excercise;

use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class ManageTrueOrFalse extends Component implements HasForms
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
                                    ->relationship('true_or_false')

                                    ->schema([

                                        Select::make('correct_answer')
                                        ->options([

                                           true => 'TRUE',
                                        false => 'FALSE',
                                        ])
                                        ->default(true)
                                        ,

                                        // Toggle::make('correct_answer')
                                        //     ->label('Answer')
                                        //     ->required(),

                                    ])->columnSpanFull(),


                            ])
                            ->defaultItems(3)
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
        return view('livewire.exercises.manage-true-or-false');
    }
}
