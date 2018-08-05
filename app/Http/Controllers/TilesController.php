<?php

namespace App\Http\Controllers;

use App\Evostorm\Repositories\BuildingRepositoryInterface;
use App\Evostorm\Repositories\GameMapRepositoryInterface;
use App\Evostorm\Models\MissionQueue;
use App\Evostorm\Models\Mission;
use App\Evostorm\Enums\MissionTypeEnum;
use App\Evostorm\Enums\MissionStatusEnum;
use Log;
use Auth;
use DB;

class TilesController extends Controller
{

    private $gameMapRepository, $buildingRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GameMapRepositoryInterface $gameMapRepository,
                                BuildingRepositoryInterface $buildingRepository)
    {
        $this->middleware('auth');
        $this->gameMapRepository = $gameMapRepository;
        $this->buildingRepository = $buildingRepository;
    }

    public function getTileInfo($id)
    {
        $tile = $this->gameMapRepository->findByIdAndUserId($id, Auth::user()->id);
        $is_occupied = false;
        $is_capture_mission_possible = true;
        $is_estimate_resource_mission_in_progress = false;
        $is_capture_mission_in_progress = false;
        $capture_mission = (object)[];
        $estimate_mission = (object)[];
        if ($tile) {
            $building_check = $this->buildingRepository->findIdByTileId($tile->id);
            if ($building_check) {
                $is_occupied = true;
            }

            $building = DB::select(DB::raw(
                "SELECT bt.name AS building_name, 
                                        bs.name AS status_name,
                                        bl.*,
                                        b.actual_gold_production as `actual_gold_production`,
                                        b.actual_uranium_production as `actual_uranium_production`,
                                        b.actual_kegrum_production as `actual_kegrum_production`,
                                        b.actual_gold_production as `actual_gold_production`,
                                        b.actual_energy_consumption as `actual_energy_consumption`,
                                        b.actual_energy_production as `actual_energy_production`
FROM buildings b
LEFT JOIN building_levels bl ON bl.id=b.building_level_id
LEFT JOIN building_types bt ON bt.id=bl.building_type_id
LEFT JOIN building_status bs ON bs.id=b.building_status_id
WHERE b.game_map_id=:tile_id LIMIT 1"), array('tile_id' => $tile->id));

            if ($building) {
                $building = $building[0];
            }

            $availableBuildings = array();

            if (!$is_occupied) {

                $availableBuildings = DB::select(DB::raw(
                    "SELECT bt.name,bl.*
FROM building_levels bl
LEFT JOIN building_types bt on bt.id=bl.building_type_id
WHERE bl.building_type_id IN (
SELECT building_type_id
FROM building_types_allowed_tile_types
WHERE tile_type_id=:tile_type_id) AND bl.level=1"), array('tile_type_id' => $tile->tile_type_id));
            }

            // Checking if there is any mission current on this tile
            $missions = Mission::where('mission_status_id', MissionStatusEnum::IN_PROGRESS)
                ->where('tile_id', $tile->id)->get();
            foreach ($missions as $mission) {
                if ($mission) {
                    if ($mission->mission_type_id == MissionTypeEnum::CAPTURE_WORKERS) {
                        $is_capture_mission_possible = false;
                        $is_capture_mission_in_progress = true;
                        $capture_mission->finish_time = MissionQueue::where('mission_id', $mission->id)->first()->finish_time;
                    } else if ($mission->mission_type_id == MissionTypeEnum::ESTIMATE_RESOURCES) {
                        $is_estimate_resource_mission_in_progress = true;
                        $estimate_mission->finish_time = MissionQueue::where('mission_id', $mission->id)->first()->finish_time;
                    }
                }
            }

            if ($tile->species_amount <= 0) {
                $is_capture_mission_possible = false;
            }

            return response()->json([
                'x_coordinate' => $tile->coord_x,
                'y_coordinate' => $tile->coord_y,
                'tile_id' => $tile->id,
                'is_occupied' => $is_occupied,
                'available_buildings' => $availableBuildings,
                'species_name' => isset($tile->species_id) ? $tile->species->name : 'inhabited',
                'species_amount' => $tile->species_amount,
                'tile_name' => $tile->tileType->name,
                'building' => $building,
                'is_capture_mission_possible' => $is_capture_mission_possible,
                'gold_left' => $tile->gold_left,
                'uranium_left' => $tile->uranium_left,
                'kegrum_left' => $tile->kegrum_left,
                'is_resources_estimated' => $tile->is_resources_estimated,
                'is_estimate_resource_mission_in_progress' => $is_estimate_resource_mission_in_progress,
                'capture_mission' => $capture_mission,
                'estimate_mission' => $estimate_mission,
                'is_capture_mission_in_progress' => $is_capture_mission_in_progress

            ]);
        } else {
            return response()->json([
                'error' => "No such tile or insufficient permissions."
            ]);
        }
    }
    
}
