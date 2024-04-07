<?php

namespace App\Models;


use App\Models\Question;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrueOrFalse extends Model
{
    use HasFactory;




    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function getCorrectAnswer()
    {
        return $this->correct_answer;

    }

   

    public function getTextAnswer(){
        
        return $this->correct_answer? 'True': 'False';

    }

    public function getShuffledOptionsAttribute($answer)
    {
        $options[] = $answer;
        $options[] = $this->getTextAnswer();
        shuffle($options);


        return Arr::flatten($options);
    }


}
