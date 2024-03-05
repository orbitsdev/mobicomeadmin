<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Excercise extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function getTotalQuestions(){
        return $this->questions()->count();
    }

    public function redirectBaseOnExerciseType(){
        $route = '';

        switch ($this->type) {
            case 'Multiple Choice':
                $route = route('manage-multiple-choice', ['record' => $this]);
                break;
                case 'True or False':
                    $route = route('manage-true-or-flase', ['record' => $this]);
                break;
            case 'Fill in the Blank':
                break;
            default:

                break;
        }

        return $route;
    }

}
