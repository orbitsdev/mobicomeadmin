<?php

namespace App\Observers;

use App\Models\Teacher;

class TeacherObserver
{
    /**
     * Handle the Teacher "created" event.
     */
    public function created(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "updated" event.
     */
    public function updated(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "deleted" event.
     */
    public function deleted(Teacher $teacher): void
    {
        $teacher->enrolled_sections()->each(function ($enrolled_section) {
            $enrolled_section->delete();
        });
        $teacher->sections()->detach();
    }

    /**
     * Handle the Teacher "restored" event.
     */
    public function restored(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "force deleted" event.
     */
    public function forceDeleted(Teacher $teacher): void
    {
        //
    }
}
