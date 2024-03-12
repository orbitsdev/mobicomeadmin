<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\View\Components\Modal;

use Illuminate\Support\Facades\Response;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Schema::defaultStringLength(191);
        Model::unguard();
        FilamentColor::register([

            'primary' => "#16a34a",

        ]);

        Modal::closedByClickingAway(false);

        Response::macro('apiResponse', function ($data = null, $status = 200, $success = true) {
            if ($success) {
                return response()->json(['data' => $data, 'success' => $success, 'status' => $status]);
            } else {
                return response()->json(['error' => $data, 'success'=> $success, 'status' => $status], $status);
            }
        });
        
    }
}
