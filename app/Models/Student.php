<?php

namespace App\Models;

use App\Models\User;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

  
   
}
