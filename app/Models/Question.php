<?php

namespace App\Models;

use App\Models\Answer;

use App\Models\Excercise;
use App\Models\TrueOrFalse;
use App\Models\FillInTheBlank;
use App\Models\MultipleChoice;
use App\Models\QuestionNumber;
use App\Models\MultipleChoiceQuestion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;


    public function excercise()
    {
        return $this->belongsTo(Excercise::class);
    }


    public function question_number()
    {
        return $this->belongsTo(QuestionNumber::class);
    }
    public function getNumber()
    {
        return $this->question_number->number;
    }


    public function multiple_choice()
    {
        return $this->hasOne(MultipleChoice::class);
    }


    public function true_or_false()
    {
        return $this->hasOne(TrueOrFalse::class);
    }
    public function fill_in_the_blank()
    {
        return $this->hasOne(FillInTheBlank::class);
    }


    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function getAnswerBaseOnType(): ?string
    {
        switch ($this->excercise->type) {
            case "Multiple Choice":
                return $this->multiple_choice->getCorrectAnswer();
                break;
            case "Fill in the Blank":
                return $this->fill_in_the_blank->getCorrectAnswer();
                break;
            case "True or False":
                return optional($this->trueOrFalse)->getTextAnswer(); // Use optional chaining
                break;
            default:
                return null; // Handle unrecognized exercise type
        }
    }
}
