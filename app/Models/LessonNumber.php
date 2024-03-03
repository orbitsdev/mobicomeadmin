<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonNumber extends Model
{
    use HasFactory;


    // public function number(){
    //     return $this->belongsTo(Number::class);
    // }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

}
