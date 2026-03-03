<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        $renderUrl = env('RENDER_EXTERNAL_URL');

        if ($renderUrl) {
            config(['app.url' => rtrim($renderUrl, '/')]);
            URL::forceRootUrl(config('app.url'));
        }

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
