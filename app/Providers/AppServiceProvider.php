<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HtmlSanitizer::class, function ($app) {
            // Create a configuration instance for the sanitizer
            $config = (new HtmlSanitizerConfig)->allowSafeElements();

            // Return a new HtmlSanitizer instance with this config
            return new HtmlSanitizer($config);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
