<?php

namespace App\Livewire;

use App\Models\TakedExam;
use Livewire\Component;

class ExerciseScoreDetails extends Component
{   

    public TakedExam $record;
    public function render()
    {
        return view('livewire.exercise-score-details');
    }
}
