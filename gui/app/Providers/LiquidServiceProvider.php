<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Liquid\CustomTemplate;
use Liquid\Template;
use Illuminate\Support\Facades\Log;

class LiquidServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Log::info(Template::getTags());
        // CustomTemplate::unregisterTags([
        //     TagInclude::class,
        // ]);

        // CustomTemplate::unregisterFilter('include');
    }
}
