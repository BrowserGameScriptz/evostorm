<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Evostorm\Models\BuildingQueue;
use App\Evostorm\Models\Building;
use App\Evostorm\Enums\BuildingStatusEnum;
use DB;
use Log;

class CheckBuildingQueue extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:building_queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks building queue and finishes buldings construction';

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
     * Every 30 seconds.
     *
     * @return mixed
     */
    public function handle() {
        $buildings = BuildingQueue::whereRaw('finish_time < NOW()')->orderBy('finish_time', 'DESC')->get();
        if ($buildings) {
            $start = microtime(true);
            foreach ($buildings as $b) {
                DB::beginTransaction();
                $building = Building::find($b->building_id);
                $building->building_status_id = BuildingStatusEnum::NON_OPERATIONAL;
                if (!$building->save()) {
                    DB::rollback();
                    Log::error("There was an error saving building ID: " . $building->id);
                }

                if (!$b->delete()) {
                    DB::rollback();
                    Log::error("There was an error deleting building queue ID: " . $b->id);
                }

                DB::commit();
                Log::info("Building successfully completed, building ID:" . $building->id);
            }
            $time_elapsed_secs = round(microtime(true) - $start, 2);
            Log::info("Find buildings in queue. Total time running: " . $time_elapsed_secs . " seconds.");
        }
    }

}
