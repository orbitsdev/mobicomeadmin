<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Excercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TakedExams extends Model
{
    use HasFactory;

    public function excercise(){
        return $this->belongsTo(Excercise::class);
    }
    public function student(){
        return $this->belongsTo(Student::class);
    }
}
