<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DemoApiController;

class getProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves properties from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new DemoApiController;
        $api->index();
    }
}
