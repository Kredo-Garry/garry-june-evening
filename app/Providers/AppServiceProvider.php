<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Paginator::useBootstrap();

        Gate::define('admin', function($user){
            return $user->role_id === USER::ADMIN_ROLE_ID; //True
        });


        /**
         * This code here is use to force the app configuration to
         * use the https --- secure verion --- HTTP (not secure), HTTPS (Secure)
         */
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    
    }
}
