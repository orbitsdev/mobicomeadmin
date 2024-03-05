<?php

namespace App\Livewire\Lessons;

use App\Models\Lesson;
use Livewire\Component;

class LessonDetails extends Component
{

    public Lesson $record;
    public function render()
    {
        return view('livewire.lessons.lesson-details');
    }
}
