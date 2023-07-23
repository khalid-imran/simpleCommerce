<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize Project';

    public function Logger(int|string $logLevel, $logLine, $logStyle = 'line')
    {
        if ($logLevel === 'alert') {
            $this->info('');
            $this->info('');
            $this->alert($logLine);
            return true;
        }

        if ($logLevel === 'warning') {
            $this->info('');
            $this->info('');
            $this->comment($logLine);
            return true;
        }

        if (is_int($logLevel)) {
            $logTab = str_repeat('   ', $logLevel);
        }

        if($logStyle == 'info'){
            $this->info($logTab . $logLine);
        }else{
            $this->line($logTab . $logLine);
        }
        return true;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        self::Logger('alert', 'Project Initialization');

        self::Logger(1, 'Wipe Database', 'info');
        Artisan::call('db:wipe');

        self::Logger(1, 'DB Migration', 'info');
        Artisan::call('migrate');

        self::Logger(1, 'DB Seed', 'info');
        Artisan::call('db:seed');

        self::Logger(1, 'Passport install', 'info');
        Artisan::call('passport:install --force');

        self::Logger(1, 'Clear config and cache', 'info');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }
}
