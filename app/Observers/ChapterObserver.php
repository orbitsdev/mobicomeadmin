<?php

namespace App\Observers;

use App\Models\Chapter;
use Illuminate\Support\Facades\Storage;

class ChapterObserver
{
    /**
     * Handle the Chapter "created" event.
     */
    public function created(Chapter $chapter): void
    {
        //
    }

    /**
     * Handle the Chapter "updated" event.
     */
    public function updated(Chapter $chapter): void
    {
        //
    }

    /**
     * Handle the Chapter "deleted" event.
     */
    public function deleted(Chapter $chapter): void
    {
        if(!empty($chapter->image_path)){

            if(Storage::disk('public')->exists($chapter->image_path)){
                Storage::disk('public')->delete($chapter->image_path);
            }
        }

        $chapter->lessons->each(function ($lesson) {
            $lesson->delete();
        });
    }

    /**
     * Handle the Chapter "restored" event.
     */
    public function restored(Chapter $chapter): void
    {
        //
    }

    /**
     * Handle the Chapter "force deleted" event.
     */
    public function forceDeleted(Chapter $chapter): void
    {
        //
    }
}
