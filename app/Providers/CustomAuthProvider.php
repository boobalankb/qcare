<?php namespace App\Providers;

use App\User;
use Auth;
use App\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class CustomAuthProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Auth::provider('custom', function($app, array $config) {
            return new CustomUserProvider('App\User');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	//
    }

}