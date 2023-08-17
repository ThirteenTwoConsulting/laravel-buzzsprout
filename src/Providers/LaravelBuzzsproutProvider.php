<?php

namespace ThirteenTwo\LaravelBuzzsprout\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelBuzzsproutProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/buzzsprout.php', 'buzzsprout');
    }
}
