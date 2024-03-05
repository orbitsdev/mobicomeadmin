<?php

namespace App\Models;

use App\Models\Excercise;

use App\Models\TrueOrFalse;
use App\Models\MultipleChoice;
use App\Models\QuestionNumber;
use App\Models\MultipleChoiceQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;


    public function excercise(){
        return $this->belongsTo(Excercise::class);
    }


    public function question_number(){
        return $this->belongsTo(QuestionNumber::class);
    }
    public function getNumber(){
        return $this->question_number->number;
    }

    public function multiple_choice(){
        return $this->hasOne(MultipleChoice::class);
    }


    public function true_or_false(){
        return $this->hasOne(TrueOrFalse::class);
    }

}
