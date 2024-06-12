<?php

namespace PHProfiler;

use Illuminate\Support\ServiceProvider;

class PHProfilerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/phprofiler.php', 'phprofiler');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/phprofiler.php' => config_path('phprofiler.php'),
        ]);
    }
}