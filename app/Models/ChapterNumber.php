<?php

namespace App\Models;

use App\Models\Chapter;
use App\Models\Cnumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChapterNumber extends Model
{
    use HasFactory;



    

    public function chapter(){
        return $this->hasOne(Chapter::class);
    }
}
