<?php

namespace App\Models;

use App\Models\Chapter;
use App\Models\LessonNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function lesson_number()
    {
        return $this->belongsTo(LessonNumber::class);
    }
    public function getNumber()
    {
        return $this->lesson_number->number;
    }

    public function videoExists()
    {
        if (!empty($this->video_path) && Storage::disk('public')->exists($this->video_path)) {
            return true;
        }
        return false;
    }
    public function imageExists()
    {
        if (!empty($this->image_path) && Storage::disk('public')->exists($this->image_path)) {
            return true;
        }
        return false;
    }
    public function getImage()
    {
        if (!empty($this->image_path) && Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }
        return asset('images/noimage.jpg');
    }

    public function getVideo()
    {
        return Storage::disk('public')->url($this->video_path);
    }
    public function getActualVideo()
    {
        if(!$this->video_path) return null;

        if (Storage::disk('public')->exists($this->video_path)) {
            
            return Storage::disk('public')->url($this->video_path);
        } else {
            
            return null; 
        }
    }
    public function getActualImage()
    {
        if(!$this->image_path) return null;
        // Check if the file exists at the given path
        if (Storage::disk('public')->exists($this->image_path)) {
            // File exists, return its URL
            return Storage::disk('public')->url($this->image_path);
        } else {
            // File does not exist, return null or handle the scenario accordingly
            return null; // or handle the scenario as per your application's requirements
        }
    }



    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function video(): MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }
}
