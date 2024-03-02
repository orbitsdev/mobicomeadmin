<?php

namespace App\Livewire\Chapters;

use App\Models\Chapter;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class ChapterDetails extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    public  Chapter $record;
    
    public function yowAction(): Action
    {
        return Action::make('yow')
     
        ;
    }
    public function render()
    {
        return view('livewire.chapters.chapter-details');
    }
}
