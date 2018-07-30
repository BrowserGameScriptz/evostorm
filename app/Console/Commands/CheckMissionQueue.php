<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Evostorm\Models\MissionQueue;
use App\Evostorm\Models\Mission;
use App\Evostorm\Models\User;
use App\Evostorm\Enums\MissionTypeEnum;
use App\Evostorm\Enums\MissionStatusEnum;
use App\Evostorm\Models\GameMap;
use App\Evostorm\Models\UserHasSpecies;
use App\Evostorm\Facades\MissionsFacade;
use Carbon\Carbon;
use DB;
use Log;

class CheckMissionQueue extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:mission_queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks mission queue and finishes missions';
    protected $missionsFacade;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MissionsFacade $missionsFacade)
    {
        $this->missionsFacade = $missionsFacade;
        parent::__construct();
    }

    /**
     * Execute the console command.
     * Every 30 seconds.
     *
     * @return mixed
     */
    public function handle()
    {
        $missions = MissionQueue::whereRaw('finish_time < NOW()')->orderBy('finish_time', 'DESC')->get();
        if ($missions) {
            $start = microtime(true);
            foreach ($missions as $m) {
                DB::beginTransaction();
                $mission = Mission::find($m->mission_id);
                $user_id = $mission->user_id;

                if (!$m->delete()) {
                    DB::rollback();
                    Log::error("There was an error deleting mission from the queue: " . $m->id);
                }

                // Let's check if mission fails
                if ($this->missionsFacade->checkIfMissionFails($mission->mission_type_id)) {
                    $mission->mission_status_id = MissionStatusEnum::FAILED;
                } else {
                    $mission->mission_status_id = MissionStatusEnum::COMPLETED;

                    switch ($mission->mission_type_id) {
                        case MissionTypeEnum::CAPTURE_WORKERS:
                            {
                                $tile = GameMap::find($mission->tile_id);
                                $amount_captured = rand(0, $tile->species_amount);
                                if ($amount_captured > 0) {
                                    $tile->species_amount = $tile->species_amount - $amount_captured;
                                    if (!$tile->save()) {
                                        DB::rollback();
                                        Log::error("There was an error saving tile: " . $tile->id);
                                    }
                                    $user_has_species = UserHasSpecies::where('user_id', $user_id)
                                        ->where('species_id', $tile->species_id)
                                        ->first();
                                    if ($user_has_species) {
                                        $user_has_species->count_total = $user_has_species->count_total + $amount_captured;
                                        $user_has_species->count_unassigned = $user_has_species->count_unassigned + $amount_captured;
                                        if (!$user_has_species->save()) {
                                            DB::rollback();
                                            Log::error("There was an error saving user's species amount: " . $user_has_species->id);
                                        }
                                    } else {
                                        $user_has_species = new UserHasSpecies();
                                        $user_has_species->user_id = $user_id;
                                        $user_has_species->species_id = $tile->species_id;
                                        $user_has_species->count_total = $amount_captured;
                                        $user_has_species->count_assigned = 0;
                                        $user_has_species->count_unassigned = $amount_captured;
                                        if (!$user_has_species->save()) {
                                            DB::rollback();
                                            Log::error("There was an error creating user's species amount: " . $user_has_species->id);
                                        }
                                    }

                                    $user = User::find($user_id);
                                    $user->amount_workforce = $user->amount_workforce + $amount_captured;
                                    if (!$user->save()) {
                                        DB::rollback();
                                        Log::error("There was an error saving user's workforce amount: " . $user->id);
                                    }

                                    $mission->result = "Captured " . $amount_captured . " individuals.";
                                }
                                break;
                            }
                        case MissionTypeEnum::ESTIMATE_RESOURCES:
                            $tile = GameMap::find($mission->tile_id);
                            $tile->is_resources_estimated = true;
                            if (!$tile->save()) {
                                DB::rollback();
                                Log::error("There was an error saving tile: " . $tile->id);
                            }
                            $mission->result = "Natural resources successfully estimated.";
                            break;
                        default:
                            {
                                Log::error("Unsupported mission type!");
                                break;
                            }
                    }
                }

                $mission->finished_at = Carbon::now();
                if (!$mission->save()) {
                    DB::rollback();
                    Log::error("There was an error updating mission status: " . $mission->id);
                }

                DB::commit();
            }
            $time_elapsed_secs = round(microtime(true) - $start, 2);
            Log::info("Find missions in queue. Total time running: " . $time_elapsed_secs . " seconds.");
        }
    }

}
