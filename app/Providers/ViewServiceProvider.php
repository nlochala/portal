<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
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
        $notifications = auth()->user() ? auth()->user()->notifications : [];

        // Using Closure based composers...
        View::composer('layouts._header_notifications', function ($view) use ($notifications) {
            $view->with('notifications', $notifications);
        });
    }
}
