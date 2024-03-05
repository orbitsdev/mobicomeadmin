<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Excercise;

class TeacherExcerciseDetails extends Component


{

    public Excercise $record;
    public function render()
    {
        return view('livewire.teacher-excercise-details');
    }
}
