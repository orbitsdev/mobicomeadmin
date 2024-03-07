<?php

namespace App\Models;

use Exception;

use App\Models\User;
use App\Models\Section;
use App\Models\TakedExam;
use App\Models\TakedExams;
use App\Models\HandledSection;
use App\Models\EnrolledSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function handled_section(){
        return $this->belongsTo(HandledSection::class);
    }
    public function enrolled_section(){
        return $this->belongsTo(EnrolledSection::class);
    }



    public function taked_exams(){
        return $this->hasMany(TakedExam::class);
    }

    public function taked_exam(){
        return $this->hasOne(TakedExam::class);
    }


    public function section()
    {

        // firt parameter ang  econnectahan mo while an g second ang agyan
        return $this->enrolled_section->section;
    }


}
