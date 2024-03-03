<?php

namespace App\Livewire\Chapters;

use App\Models\Lesson;
use Livewire\Component;

class LessonDetails extends Component
{   

    public Lesson $record;
    public function render()
    {
        return view('livewire.chapters.lesson-details');
    }
}
