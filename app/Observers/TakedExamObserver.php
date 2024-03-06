<?php

namespace App\Observers;

use App\Models\TakedExam;

class TakedExamObserver
{
    /**
     * Handle the TakedExam "created" event.
     */
    public function created(TakedExam $takedExam): void
    {
        //
    }

    /**
     * Handle the TakedExam "updated" event.
     */
    public function updated(TakedExam $takedExam): void
    {
        //
    }

    /**
     * Handle the TakedExam "deleted" event.
     */
    public function deleted(TakedExam $takedExam): void
    {
        $takedExam->answers()->delete();
    }

    /**
     * Handle the TakedExam "restored" event.
     */
    public function restored(TakedExam $takedExam): void
    {
        //
    }

    /**
     * Handle the TakedExam "force deleted" event.
     */
    public function forceDeleted(TakedExam $takedExam): void
    {
        //
    }
}
