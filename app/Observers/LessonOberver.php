<?php

namespace App\Observers;

use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class LessonOberver
{
    /**
     * Handle the Lesson "created" event.
     */
    public function created(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "updated" event.
     */
    public function updated(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "deleted" event.
     */
    public function deleted(Lesson $lesson): void
    {
        if(!empty($lesson->image_path)){

            if(Storage::disk('public')->exists($lesson->image_path)){
                Storage::disk('public')->delete($lesson->image_path);
            }
        }
        if(!empty($lesson->video_path)){

            if(Storage::disk('public')->exists($lesson->video_path)){
                Storage::disk('public')->delete($lesson->video_path);
            }
        }
    }

    /**
     * Handle the Lesson "restored" event.
     */
    public function restored(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "force deleted" event.
     */
    public function forceDeleted(Lesson $lesson): void
    {
        //
    }
}
