<?php

namespace App\Providers;
use App\Http\Controllers\UserNotificationsController;

use App\Channel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


       
        \View::composer(['layouts.app', 'threads.create'], function($view){
            $channels=\Cache::rememberForever('channel', function(){
                return Channel::all();
            });

            $view->with('channels', $channels);
            
       });

    

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
 
    }
}
