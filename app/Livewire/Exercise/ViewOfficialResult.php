<?php

namespace App\Livewire\Exercise;

use App\Models\Excercise;
use App\Models\TakedExam;
use Livewire\Component;

class ViewOfficialResult extends Component
{

     public TakedExam $record;

     public function mount(){
        
        $this->record = TakedExam::whereHas('excercise', function($query){
            $query->where('type', Excercise::MULTIPLECHOICE);
        })->first();
     }
    public function render()
    {
        return view('livewire.exercise.view-official-result');
    }
}
