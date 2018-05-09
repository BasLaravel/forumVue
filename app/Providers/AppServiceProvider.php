<?php

namespace App\Providers;
use App\Http\Controllers\UserNotificationsController;


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

            $view->with('channels', \App\Channel::all());
            
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
