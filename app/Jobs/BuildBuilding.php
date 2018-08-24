<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;

class BuildBuilding implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $building_level_id, $tile_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($building_level_id, $tile_id)
    {
        $this->building_level_id = $building_level_id;
        $this->tile_id = $tile_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Steps
         * 1. Check if tile exists and belongs to authenticated user
         * 2. Check if building level exits
         * 3. Check we are allowed to build on this tile
         * 4. Check if user has enough resources to build
         * 5. Create building
         * 6. Add building to building queue
         * 6. Update user resources
         * 7. Erase tile's population
         */
        // Check if tile exists and belongs to authenticated user
        $tile = Tile::where('id', $this->tile_id)->where('user_id', Auth::user()->id)->first();
        if (!$tile) {
            return $this->error("The given tile does not exist or you don't have permissions to it.");
        }

        // Check if building level exists
        $buildingLevel = BuildingLevel::where('id', $this->building_level_id)->where('level', 1)->first();
        if (!$buildingLevel) {
            return $this->error("The given building does not exist.");
        }

        // Now check if we can build a building of this type on this tile
        $is_allowed = $this->buildingsFacade->checkBuildingAllowedToBuildOnTile($buildingLevel, $tile);
        if (!$is_allowed) {
            return $this->error("You can't build this building on this tile type.");
        }

        // Check if user has enough resources to build this building
        $has_resources = $this->buildingsFacade->checkEnoughResourcesToBuild($buildingLevel, Auth::user());
        if (!$has_resources) {
            return $this->error("You don't have enough resources to build this building.");
        }

        DB::beginTransaction();

        // Creating the building
        $building = new Building();
        $building->user_id = $tile->user_id;
        $building->tile_id = $tile->id;
        $building->building_level_id = $buildingLevel->id;
        $building->building_status_id = BuildingStatusEnum::BUILDING_IN_PROGRESS;
        if (!$building->save()) {
            DB::rollback();
            return $this->saveError();
        }

        // Updating resources
        $user = Auth::user();
        $user->amount_gold = $user->amount_gold - $buildingLevel->gold_cost;
        $user->amount_uranium = $user->amount_uranium - $buildingLevel->uranium_cost;
        $user->amount_kegrum = $user->amount_kegrum - $buildingLevel->kegrum_cost;
        if (!$user->save()) {
            DB::rollback();
            return $this->saveError();
        }

        // Adding to the building queue
        $queue = new BuildingQueue();
        $queue->building_id = $building->id;
        $queue->finish_time = Carbon::now('Europe/Warsaw')->addMinutes($buildingLevel->build_time);

        if (!$queue->save()) {
            DB::rollback();
            return $this->saveError();
        }

        // Erasing tile's population (construction causes all individuals to die)
        $tile->species_id = null;
        $tile->species_amount = 0;
        if (!$tile->save()) {
            DB::rollback();
            return $this->saveError();
        }
    }
}
