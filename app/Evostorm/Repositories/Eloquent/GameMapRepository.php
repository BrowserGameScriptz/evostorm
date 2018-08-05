<?php

namespace App\Evostorm\Repositories\Eloquent;


use App\Evostorm\Models\GameMap;
use App\Evostorm\Repositories\GameMapRepositoryInterface;
use DB;

class GameMapRepository extends AbstractRepository implements GameMapRepositoryInterface
{
    public function __construct(GameMap $model)
    {
        $this->model = $model;
    }

    /**
     * Returns list of all tiles of a given user
     * @param $user_id
     * @return GameMap objects list
     */
    public function findListByUserId($user_id)
    {
        return DB::select(DB::raw(
            "SELECT gm.id AS `id`, gm.coord_x AS `coord_x`, gm.coord_y AS `coord_y`, gm.tile_type_id AS `tile_type_id`, b.building_level_id AS `building_level_id`, b.building_status_id AS `building_status_id`
FROM game_map gm
LEFT JOIN buildings b ON b.game_map_id=gm.id
WHERE gm.user_id=:user_id ORDER BY gm.id ASC;"), array('user_id' => $user_id));
    }

    public function findByIdAndUserId($tile_id, $user_id)
    {
        return $this->model->where('id', $tile_id)->where('user_id', $user_id)->first();
    }

}