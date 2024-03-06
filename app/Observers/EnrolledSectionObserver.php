<?php

namespace App\Observers;

use App\Models\EnrolledSection;

class EnrolledSectionObserver
{
    /**
     * Handle the EnrolledSection "created" event.
     */
    public function created(EnrolledSection $enrolledSection): void
    {
        //
    }

    /**
     * Handle the EnrolledSection "updated" event.
     */
    public function updated(EnrolledSection $enrolledSection): void
    {
        //
    }

    /**
     * Handle the EnrolledSection "deleted" event.
     */
    public function deleted(EnrolledSection $enrolledSection): void
    {
         $enrolledSection->students()->delete();
    }

    /**
     * Handle the EnrolledSection "restored" event.
     */
    public function restored(EnrolledSection $enrolledSection): void
    {
        //
    }

    /**
     * Handle the EnrolledSection "force deleted" event.
     */
    public function forceDeleted(EnrolledSection $enrolledSection): void
    {
        //
    }
}
