<?php

namespace App\Jobs;

use App\Evostorm\Enums\BuildingStatusEnum;
use App\Evostorm\Exceptions\Tile\UserTileNotFoundException;
use App\Evostorm\Facades\Contracts\BuildingsFacadeInterface;
use App\Evostorm\Facades\Contracts\ResourcesFacadeInterface;
use App\Evostorm\Facades\Contracts\TilesFacadeInterface;
use App\Evostorm\Repositories\BuildingRepositoryInterface;
use App\Evostorm\Repositories\TileRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Auth;
use Log;

class BuildBuilding implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $building_level_id, $tile_id;
    private $tileRepository;
    private $buildingRepository;
    private $resourcesFacade;
    private $tilesFacade;
    private $buildingsFacade;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($building_level_id,
                                $tile_id)
    {
        $this->building_level_id = $building_level_id;
        $this->tile_id = $tile_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        TileRepositoryInterface $tileRepository,
        BuildingRepositoryInterface $buildingRepository,
        ResourcesFacadeInterface $resourcesFacade,
        TilesFacadeInterface $tilesFacade,
        BuildingsFacadeInterface $buildingsFacade)
    {
        $this->tileRepository = $tileRepository;
        $this->buildingRepository = $buildingRepository;
        $this->resourcesFacade = $resourcesFacade;
        $this->tilesFacade = $tilesFacade;
        $this->buildingsFacade = $buildingsFacade;
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
        $tile = $this->tileRepository->findByIdAndUserId($this->tile_id, Auth::user()->id);
        if (!$tile) {
            throw new UserTileNotFoundException();
        }

        // Check if building level exists
        $buildingLevel = $this->buildingRepository->findBuildingFirstLevelById($this->building_level_id);
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

        $building = $this->createBuilding($tile, $buildingLevel);

        $this->resourcesFacade->updateUserResourcesByCost(Auth::user(), $buildingLevel->cost);

        $this->buildingRepository->addBuildingToQueue($building, $buildingLevel);

        $this->tilesFacade->erasePopulation($tile);
    }

    /**
     * @param $tile
     * @param $buildingLevel
     * @return mixed
     */
    private function createBuilding($tile, $buildingLevel)
    {
        $building = $this->buildingRepository->create(array(
            'user_id' => $tile->user_id,
            'tile_id' => $tile->id,
            'building_level_id' => $buildingLevel->id,
            'building_status_id' => BuildingStatusEnum::BUILDING_IN_PROGRESS
        ));
        return $building;
    }
}
