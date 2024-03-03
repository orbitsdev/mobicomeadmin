<?php

namespace App\Livewire\Chapters;

use App\Models\Chapter;
use Livewire\Component;

class ManageLessons extends Component
{

    public  Chapter $record;

    public function render()
    {
        return view('livewire.chapters.manage-lessons');
    }
}
