<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnrolledSection extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    public function students(){
        return $this->hasMany(Student::class);
    }

    public function getTotalStudent(){
        return $this->students()->count();
    }

    


}
