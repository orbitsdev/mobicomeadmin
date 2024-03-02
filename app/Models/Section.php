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


    public function handled_sections(){
        return $this->hasMany(HandledSection::class);
    }
}
