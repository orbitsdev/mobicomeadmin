<?php

namespace App\Models;

use App\Models\Feed;
use App\Models\Answer;
use App\Models\Student;
use App\Models\Excercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TakedExam extends Model
{
    use HasFactory;


    public function excercise(){
        return $this->belongsTo(Excercise::class);
    }
    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function getTotalScore()
    {
        return $this->answers->where('status', true)->count();
    }
    public function getTotalWrongScore()
    {
        return $this->answers->where('status', false)->count();
    }
    public function getQuestionThatHasWrongAnswers()
    {
        return $this->excercise->questions()
            ->whereHas('answers', function ($query) {
                $query->where('status', false);
            })
            ->get();
    }
    
    public function getQuestionThatHasCorrectAnswers()
    {
        return $this->excercise->questions()
            ->whereHas('answers', function ($query) {
                $query->where('status', true);
            })
            ->get();
    }
    
    public function getTotalExerciseQuestions()
    {
        return $this->excercise->questions()->count();
    }


    public function feed(){
        return $this->hasOne(Feed::class);
    }

}
