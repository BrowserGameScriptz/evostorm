<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Illuminate\Support\Facades\DB;

class ResetApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the application';

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
     * @return mixed
     */
    public function handle()
    {
        Log::info("Resetting the application...");
        Log::info("Creating the database");
        DB::connection()->getPdo()->exec('DROP DATABASE IF EXISTS `evostorm_db`;');
        DB::connection()->getPdo()->exec("CREATE DATABASE `evostorm_db` /*!40100 COLLATE 'utf8_general_ci' */;");
        DB::connection()->getPdo()->exec("USE `evostorm_db`;");
        $this->call('migrate', []);
        $this->call('db:seed', []);
        Log::info("COMPLETE");
    }
}
