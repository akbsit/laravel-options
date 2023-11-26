<?php

declare(strict_types=1);

namespace Akbsit\Options;

use Illuminate\Support\ServiceProvider;

final class OptionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
