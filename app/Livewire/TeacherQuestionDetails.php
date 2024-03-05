<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Question;

class TeacherQuestionDetails extends Component
{
    public Question $record;
    public function render()
    {
        return view('livewire.teacher-question-details');
    }
}
