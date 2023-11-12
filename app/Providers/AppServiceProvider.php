<?php
 
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
 
// 追記
use Illuminate\Support\Facades\URL;
 
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
        // 追記
        URL::forceScheme('https');
    }
}