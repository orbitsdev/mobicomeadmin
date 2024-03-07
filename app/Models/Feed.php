<?php

namespace App\Models;

use App\Models\TakedExam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{
    use HasFactory;

    public function taked_exam(){
        return $this->belongsTo(TakedExam::class);
    }
}
