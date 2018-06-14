<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\User;
class CustomBladeProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      
        Blade::directive('issAdmin', function(){
            return "<?php if( auth()->user()->isAdmin()): ?>";
        });

        Blade::directive('endissAdmin', function () {
            return "<?php endif; ?>";
        });
       

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // zomaar wat tekst
    }
}
