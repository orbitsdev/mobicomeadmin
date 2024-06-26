<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Student;

use App\Models\Excercise;
use App\Models\RemoveRequest;
use App\Models\HandledSection;
use App\Models\EnrolledSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }


    public function role(){
        return $this->user->role;
    }


    public function sections(){
        return $this->belongsToMany(Section::class,'enrolled_sections','teacher_id','section_id');
    }
    public function enrolled_sections(){
        return $this->hasMany(EnrolledSection::class);
       }
       public function enrolled_section(){
        return $this->hasOne(EnrolledSection::class);
       }

       public function getIsApprovedString(){
        return $this->is_approved ? 'Active' : 'Not Active';
       }


       public function students()
       {
           return $this->hasManyThrough(Student::class, EnrolledSection::class);
       }
       public function excercises()
       {
           return $this->user->excercises;
       }

       public function remove_requests(){
        return $this->hasMany(RemoveRequest::class);
    }
}
