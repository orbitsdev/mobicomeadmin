<?php

namespace App\Livewire;

use App\Models\Chapter;
use Livewire\Component;

class ManageChapter extends Component
{

    public  Chapter $record;
    
    public function render()
    {
        return view('livewire.manage-chapter');
    }
}
