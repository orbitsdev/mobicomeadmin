<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;


    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

    public function getTotalLessons(){
        return $this->lessons()->count();
    }
    public function getTitle(){
        return $this->chapter_number." ".$this->title;
    }

    public function getImage(){

        if(!empty($this->image_path)){
            return Storage::disk('public')->url($this->image_path);

        }else{
            return asset('images/noimage.jpg');
        }
    }
    public function getLatestChapterNumber(){
        $latestChapter = $this->latest()->first();
        return $latestChapter ? $latestChapter->chapter_number : 'N';
    }
    

    
}
