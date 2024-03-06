<?php

namespace App\Models;

use App\Models\User;

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


}