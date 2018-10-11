<?php

namespace App\Evostorm\Jobs;

use App\Evostorm\Enums\BuildingStatusEnum;
use App\Evostorm\Exceptions\Building\BuildingTypeNotAllowedException;
use App\Evostorm\Exceptions\Building\NoSuchBuildingLevelException;
use App\Evostorm\Exceptions\Resources\NotEnoughResourcesException;
use App\Evostorm\Facades\Contracts\BuildingsFacadeInterface;
use App\Evostorm\Facades\Contracts\ResourcesFacadeInterface;
use App\Evostorm\Facades\Contracts\TilesFacadeInterface;
use App\Evostorm\Facades\Contracts\UsersFacadeInterface;
use App\Evostorm\Models\User;
use App\Evostorm\Repositories\BuildingRepositoryInterface;
use App\Evostorm\Repositories\TileRepositoryInterface;
use App\Evostorm\Traits\ChecksTileExists;
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
    use ChecksTileExists;

    private $building_level_id, $tile_id, $user;
    private $tileRepository;
    private $buildingRepository;
    private $resourcesFacade;
    private $tilesFacade;
    private $buildingsFacade;
    private $usersFacade;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($building_level_id,
                                $tile_id, User $user)
    {
        $this->building_level_id = $building_level_id;
        $this->tile_id = $tile_id;
        $this->user = $user;
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
        BuildingsFacadeInterface $buildingsFacade,
        UsersFacadeInterface $usersFacade)
    {
        $this->tileRepository = $tileRepository;
        $this->buildingRepository = $buildingRepository;
        $this->resourcesFacade = $resourcesFacade;
        $this->tilesFacade = $tilesFacade;
        $this->buildingsFacade = $buildingsFacade;
        $this->usersFacade = $usersFacade;

        $this->build();
    }

    private function build()
    {
        $tile = $this->checkUserTileExists($this->tile_id, $this->user);

        $buildingLevel = $this->buildingRepository->findBuildingFirstLevelById($this->building_level_id);
        if (!$buildingLevel) {
            throw new NoSuchBuildingLevelException();
        }

        $is_allowed = $this->buildingsFacade->checkBuildingAllowedToBuildOnTile($buildingLevel, $tile);
        if (!$is_allowed) {
            throw new BuildingTypeNotAllowedException();
        }

        $this->checkUserHasEnoughResources($buildingLevel->cost);
        $building = $this->createBuilding($tile, $buildingLevel);
        $this->resourcesFacade->updateUserResourcesByCost($this->user, $building->level->cost);
        $this->buildingRepository->addBuildingToQueue($building);
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

    /**
     * @param $cost
     * @throws NotEnoughResourcesException
     */
    public function checkUserHasEnoughResources($cost): void
    {
        $has_resources = $this->usersFacade->checkHasEnoughResources($this->user, $cost);
        if (!$has_resources) {
            throw new NotEnoughResourcesException();
        }
    }
}
