<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class RegenerateIdeHelperAfterMigration
{
    public function handle()
    {
        Artisan::call('ide-helper:generate');
        Artisan::call('ide-helper:models', ['--nowrite' => true]);
    }
}
