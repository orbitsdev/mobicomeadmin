<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\ChapterNumber;
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
            return "https://images.unsplash.com/photo-1612177241462-d254edf4e823?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=800&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTcxMDMyNzU3Ng&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1900";
        }
    }
    public function getLocalImage(){    



        if(!empty($this->image_path)){
            $path = Storage::disk('public')->url($this->image_path);
            // return 'https://images.unsplash.com/photo-1612177241462-d254edf4e823?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=800&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTcxMDMyNzU3Ng&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1900';
            return str_replace('http://127.0.0.1:8000','http://192.168.1.51:8000', $path);


        }else{
            return "https://images.unsplash.com/photo-1612177241462-d254edf4e823?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=800&ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTcxMDMyNzU3Ng&ixlib=rb-4.0.3&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1900";
        }
    }
    public function getLatestChapterNumber(){
        $latestChapter = $this->latest()->first();
        return $latestChapter ? $latestChapter->chapter_number : 'N';
    }

    public function chapter_number(){
        return $this->belongsTo(ChapterNumber::class);
    }
    public function number(){
        return $this->chapter_number->number;
    }
    

    
}
