<?php

namespace App\Livewire\Exercise;

use App\Models\TakedExam;
use Livewire\Component;

class ViewOfficialResult extends Component
{

     public TakedExam $record;
    public function render()
    {
        return view('livewire.exercise.view-official-result');
    }
}
