<?php

namespace App\Models;

use App\Models\Question;

use App\Models\TakedExam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    public function taked_exam()
    {
        return $this->belongsTo(TakedExam::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function compareUserAnswer($actual_answer, $type)
    {
        switch ($type) {
            case 'Multiple Choice':
            case 'Fill in the Blank':
            case 'True or False':
                return strtolower($this->answer) === strtolower($actual_answer) ? 'Correct' : 'Wrong';
            default:
                return 'Wrong'; // Handle unsupported question types
        }
    }

}
