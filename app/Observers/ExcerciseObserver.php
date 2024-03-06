<?php

namespace App\Observers;

use App\Models\Excercise;

class ExcerciseObserver
{
    /**
     * Handle the Excercise "created" event.
     */
    public function created(Excercise $excercise): void
    {
        //
    }

    /**
     * Handle the Excercise "updated" event.
     */
    public function updated(Excercise $excercise): void
    {
        //
    }

    /**
     * Handle the Excercise "deleted" event.
     */
    public function deleted(Excercise $excercise): void
    {
        $excercise->questions()->delete();
        $excercise->taked_exams()->delete();
           
       
    }

    /**
     * Handle the Excercise "restored" event.
     */
    public function restored(Excercise $excercise): void
    {
        //
    }

    /**
     * Handle the Excercise "force deleted" event.
     */
    public function forceDeleted(Excercise $excercise): void
    {
        //
    }
}
