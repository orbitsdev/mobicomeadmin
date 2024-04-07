<?php

namespace App\Livewire\Exercise;

use App\Models\Excercise;
use App\Models\TakedExam;
use Livewire\Component;

class ViewOfficialResult extends Component
{

     public TakedExam $record;

    //  public function mount(){
        
    //     $this->record = TakedExam::whereHas('excercise', function($query){
    //         $query->where('type', Excercise::FILL_IN_THE_BLANK);
    //     })->first();

    // //  dd($this->record);
    //  }
    public function render()
    {
        return view('livewire.exercise.view-official-result');
    }
}
