<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;

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
