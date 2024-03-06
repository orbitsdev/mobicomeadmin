<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
use App\Models\TakedExam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Excercise extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function getTotalQuestions()
    {
        return $this->questions()->count();
    }

    public function redirectBaseOnExerciseType()
    {
        $route = '';

        switch ($this->type) {
            case 'Multiple Choice':
                $route = route('manage-multiple-choice', ['record' => $this]);
                break;
            case 'True or False':
                $route = route('manage-true-or-false', ['record' => $this]);
                break;
            case 'Fill in the Blank':
                $route = route('manage-fill-in-the-blank', ['record' => $this]);
                break;
            default:

                break;
        }

        return $route;
    }
    public function teacherRedirectBaseOnExerciseType()
    {
        $route = '';

        switch ($this->type) {
            case 'Multiple Choice':
                $route = route('teacher-manage-multiple-choice', ['record' => $this]);
                break;
            case 'True or False':
                $route = route('teacher-manage-true-or-false', ['record' => $this]);
                break;
            case 'Fill in the Blank':
                $route = route('teacher-manage-fill-in-the-blank', ['record' => $this]);
                break;
            default:

                break;
        }

        return $route;
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'taked_exams', 'excercise_id', 'student_id');
    }

    public function taked_exams(){
        return $this->hasMany(TakedExam::class);
    }

  

    
// $totalScore = $exercise->takedExams->sum(function ($takedExam) {
//     return $takedExam->answers->where('status', true)->count();
// });
}
