<?php

namespace App\Models;

use App\Models\Excercise;
use App\Models\QuestionNumber;
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
}
