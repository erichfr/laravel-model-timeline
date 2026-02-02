<?php

declare(strict_types=1);

namespace ErpPackages\ModelTimeline;

use Illuminate\Support\ServiceProvider;

class ModelTimelineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Publica a migration para que ela rode junto com as do projeto principal
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register(): void
    {
        //
    }
}