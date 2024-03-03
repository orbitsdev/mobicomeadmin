<?php

namespace App\Livewire\Questions;

use App\Models\Question;
use Livewire\Component;

class QuestionDetails extends Component
{   

    public Question $record;
    public function render()
    {
        return view('livewire.questions.question-details');
    }
}
