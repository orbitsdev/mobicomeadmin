<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\View\Components\Modal;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {


        Gate::define('admin-and-teacher', function () {
            return Auth::user()->isAdmin() || Auth::user()->isTeacher() ;
        });
        Gate::define('is-admin', function () {

            return Auth::user()->isAdmin();
        });

        Gate::define('is-teacher', function () {
            return (Auth::user()->isTeacher() || Auth::user()->teacher);
        });



        Gate::define('is-student', function () {

            return Auth::user()->isStudent();
        });



    }
}
