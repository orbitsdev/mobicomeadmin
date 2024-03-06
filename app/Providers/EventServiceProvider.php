<?php

namespace App\Providers;

use App\Models\Chapter;
use App\Models\EnrolledSection;
use App\Models\Excercise;
use App\Models\Lesson;
use App\Models\TakedExam;
use App\Models\Teacher;
use App\Models\User;
use App\Observers\ChapterObserver;
use App\Observers\EnrolledSectionObserver;
use App\Observers\ExcerciseObserver;
use App\Observers\LessonOberver;
use App\Observers\TakedExamObserver;
use App\Observers\TeacherObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Chapter::observe(ChapterObserver::class);
        Lesson::observe(LessonOberver::class);
        Excercise::observe(ExcerciseObserver::class);
        Teacher::observe(TeacherObserver::class);
        EnrolledSection::observe(EnrolledSectionObserver::class);
        TakedExam::observe(TakedExamObserver::class);

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
