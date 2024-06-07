<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions using Althinect/filament-spatie-roles-permissions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Menjalankan Althinect/filament-spatie-roles-permissions untuk menghasilkan permissions
        Artisan::call('permissions:sync');
    }
}