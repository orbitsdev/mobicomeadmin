<?php

namespace App\Livewire\Exercises;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Excercise;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class ManageExercise extends Component implements HasForms
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
                Section::make()
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([


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
        return view('livewire.exercises.manage-exercise');
    }
}
