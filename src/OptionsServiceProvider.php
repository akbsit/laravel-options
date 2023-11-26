<?php

declare(strict_types=1);

namespace Akbsit\Options;

use Akbsit\Options\Observers\OptionObserver;
use Illuminate\Support\ServiceProvider;
use Akbsit\Options\Models\Option as OptionModel;

final class OptionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        OptionModel::observe(OptionObserver::class);
    }

    public function register(): void
    {
        $this->app->bind('option', Option::class);
    }
}
