<?php

namespace App\Evostorm\Facades;

use App\Evostorm\Facades\Contracts\BuildingsFacadeInterface;
use App\Evostorm\Models\BuildingLevel;
use App\Evostorm\Models\User;
use App\Evostorm\Models\Tile;
use DB;

/**
 * Description of ResourcesFacade
 *
 * @author damian
 */
class BuildingsFacade implements BuildingsFacadeInterface
{

    public function checkEnoughResourcesToBuild(BuildingLevel $buildingLevel, User $user)
    {
        if ((($user->amount_gold - $buildingLevel->gold_cost) < 0) || (($user->amount_uranium - $buildingLevel->uranium_cost) < 0) || (($user->amount_kegrum - $buildingLevel->kegrum_cost) < 0)
        ) {
            return false;
        } else {
            return true;
        }
    }

    public function checkBuildingAllowedToBuildOnTile(BuildingLevel $buildingLevel, Tile $tile)
    {
        $allowed = DB::select(DB::raw("SELECT EXISTS(SELECT 1 FROM building_types_allowed_tile_types WHERE building_type_id =:building_type_id AND tile_type_id=:tile_type_id LIMIT 1) as is_allowed"), array('building_type_id' => $buildingLevel->building_type_id, 'tile_type_id' => $tile->tile_type_id));
        return $allowed[0]->is_allowed;
    }

}
