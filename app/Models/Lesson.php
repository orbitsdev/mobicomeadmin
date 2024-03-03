<?php

namespace App\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }

    public function videoExists()
{
    if (!empty($this->video_path) && Storage::disk('public')->exists($this->video_path)) {
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

public function getVideo(){
    return Storage::disk('public')->url($this->video_path);
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
