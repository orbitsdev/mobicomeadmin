<?php

namespace App\Models;

use App\Models\LessonNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Number extends Model
{
    use HasFactory;

    public function lesson_number(){
        return $this->hasMany(LessonNumber::class);
    }


}
