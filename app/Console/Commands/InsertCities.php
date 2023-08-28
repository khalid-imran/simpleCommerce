<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;

class InsertCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        City::truncate();
        $d = file_get_contents(public_path('backup/cities.json'));
        $d = json_decode($d, true);
        City::insert($d);
    }
}
