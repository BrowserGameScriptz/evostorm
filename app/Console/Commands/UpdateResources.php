<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Illuminate\Support\Facades\DB;

class UpdateResources extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the resources of the users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $start = microtime(true);
        DB::beginTransaction();
        DB::update("UPDATE users SET 
amount_gold=amount_gold+(balance_gold),
amount_uranium=amount_uranium+(balance_uranium),
amount_food=amount_food+(balance_food),
amount_workforce=amount_workforce+(balance_workforce),
amount_kegrum=amount_kegrum+(balance_kegrum);");
        DB::update("UPDATE game_map SET 
gold_left=gold_left-gold_usage,
uranium_left=uranium_left-uranium_usage,
kegrum_left=kegrum_left-kegrum_usage where is_used=true;");
        DB::commit();
        $time_elapsed_secs = round(microtime(true) - $start, 2);
        Log::info("Updating resources. Total time running: " . $time_elapsed_secs . " seconds.");
    }

}
