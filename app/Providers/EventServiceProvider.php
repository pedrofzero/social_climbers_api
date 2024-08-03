<?php

namespace App\Providers;

use App\Listeners\RegenerateIdeHelperAfterMigration;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MigrationsEnded::class => [
            RegenerateIdeHelperAfterMigration::class,
        ],
    ];
}
