<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Student;

use App\Models\HandledSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }


    public function sections(){
        return $this->belongsToMany(Section::class,'handled_sections','teacher_id','section_id');
    }
   public function handled_sections(){
    return $this->hasMany(HandledSection::class);
   }
   public function handled_section(){
    return $this->hasOne(HandledSection::class);
   }
}
