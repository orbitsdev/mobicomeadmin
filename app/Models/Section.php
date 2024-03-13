<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Teacher;

use App\Models\HandledSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;




    public function teachers(){
        return $this->belongsToMany(Teacher::class,'enrolled_sections','section_id','teacher_id');
    }

    public function enrolled_sections(){
        return $this->hasMany(EnrolledSection::class);
       }
       public function enrolled_section(){
        return $this->hasOne(EnrolledSection::class);
       }


    //    public function sectionWithTeacher(){
    //     return $this->all()->map(function($item){});
    //    }

}
