<?php

namespace App\Livewire\Excercises;

use App\Models\Excercise;
use Livewire\Component;

class ExerciseDetails extends Component
{

    public Excercise $record;
    public function render()
    {
        return view('livewire.excercises.exercise-details');
    }
}
