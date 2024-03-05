<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FillInTheBlank extends Model
{   

    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function getCorrectAnswer(){
        return $this->correct_answer;
    }
    use HasFactory;
}
