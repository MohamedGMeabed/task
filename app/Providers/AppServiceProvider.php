<?php

namespace App\Providers;

use App\Models\User;
use Facade\FlareClient\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('auth.login', function ($view) {
            $user = User::where('email', request()->email)->first();

            $view->with([
                'user' => $user,
            ]);
        });
    }
}
