<?php

namespace App\Livewire\Chapters;

use App\Models\Chapter;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
class ChapterDetails extends Component 
{


    public  Chapter $record;
    
    
   
    public function render()
    {


        return view('livewire.chapters.chapter-details');
    }
}
