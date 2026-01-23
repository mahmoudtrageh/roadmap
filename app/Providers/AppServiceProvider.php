<?php

namespace App\Providers;

use App\Models\TaskCompletion;
use App\Observers\TaskCompletionObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        // Fix for cPanel MySQL index key length limitation
        Schema::defaultStringLength(191);

        // Register observers
        TaskCompletion::observe(TaskCompletionObserver::class);
    }
}
