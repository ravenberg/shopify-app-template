<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckAppKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-app-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an app key if not yet present';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appKey = config('app.key');
        if (!$appKey) {
            $this->call('key:generate');
            $this->info('App key generated.');
        }
    }
}
