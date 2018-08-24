<?php

namespace App\Http\Controllers;

use App\Evostorm\Facades\Contracts\BuildingsFacadeInterface;
use App\Evostorm\Models\UserHasSpecies;
use App\Evostorm\Models\Tile;
use App\Evostorm\Models\BuildingLevel;
use App\Evostorm\Models\Building;
use App\Evostorm\Models\BuildingQueue;
use App\Evostorm\Enums\BuildingStatusEnum;
use App\Evostorm\Models\BuildingWorker;
use App\Jobs\BuildBuilding;
use Auth;
use Carbon\Carbon;
use DB;
use Log;

class BuildingsController extends Controller
{

    protected $buildingsFacade;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BuildingsFacadeInterface $buildingsFacade)
    {
        $this->buildingsFacade = $buildingsFacade;
    }

    public function build($building_level_id, $tile_id)
    {
        try {
            DB::beginTransaction();
            $this->dispatch(new BuildBuilding($building_level_id, $tile_id));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->saveError();
        }
        DB::commit();
        return response()->json([
            'success' => "success"
        ]);
    }

    public function getUserBuildings()
    {
        $buildings = Building::where('user_id', Auth::user()->id)->get();

        $buildingsArray = Array();

        foreach ($buildings as $b) {
            $o = (object)[];
            $s = (object)[];
            $workersArray = Array();

            $o->type = $b->level->type->name;
            $o->level = $b->level->level;
            $o->tile_id = $b->tile->id;
            $o->tile_coord_x = $b->tile->coord_x;
            $o->tile_coord_y = $b->tile->coord_y;
            $o->status = $b->status->name;

            $o->gold_production = $b->actual_gold_production;
            $o->uranium_production = $b->actual_uranium_production;
            $o->kegrum_production = $b->actual_kegrum_production;
            $o->energy_production = $b->actual_energy_production;

            $o->gold_consumption = $b->actual_gold_upkeep;
            $o->uranium_consumption = $b->actual_uranium_upkeep;
            $o->kegrum_consumption = $b->actual_kegrum_upkeep;
            $o->energy_consumption = $b->actual_energy_consumption;

            $o->min_workers_amount = $b->level->min_workers_amount;
            $o->max_workers_amount = $b->level->max_workers_amount;

            $workers = BuildingWorker::where('building_id', $b->id)->get();

            foreach ($workers as $w) {
                $s->species_name = $w->species->name;
                $s->amount = $w->amount;
                array_push($workersArray, $s);
            }

            $o->workers = $workersArray;

            array_push($buildingsArray, $o);
        }

        return response()->json([
            'buildings' => $buildingsArray
        ]);
    }

    public function assignWorkers($building_id, $species_id, $amount)
    {
        $building = Building::where('id', $building_id)->where('user_id', Auth::user()->id)->first();
        if (!$building) {
            return $this->error("The given building does not exist or you don't have permissions to it.");
        }

        $uhs = UserHasSpecies::where('user_id', Auth::user()->id)->where('species_id', $species_id)->first();
        if (!$uhs) {
            return $this->error("You don't have any individual of this species or species does not exist.");
        }

        if ($amount > $uhs->count_unassigned) {
            return $this->error("The amount of workers you try to assign is to large.");
        }

        DB::beginTransaction();

        $uhs->count_assigned = $uhs->count_assigned + $amount;
        $uhs->count_unassigned = $uhs->count_unassigned - $amount;

        if (!$uhs->save()) {
            DB::rollback();
            return $this->saveError();
        }

        $bw = BuildingWorker::where('building_id', $building_id)->where('species_id', $species_id)->first();
        if (!$bw) {
            $bw = new BuildingWorker();
            $bw->building_id = $building_id;
            $bw->species_id = $species_id;
            $bw->amount = amount;

            if (!$bw->save()) {
                DB::rollback();
                return $this->saveError();
            }
        } else {

        }
    }

}
