<?php

namespace App\Http\Controllers;

use App\Evostorm\Facades\Contracts\MissionsFacadeInterface;
use App\Evostorm\Repositories\MissionRepositoryInterface;
use App\Evostorm\Models\GameMap;
use App\Evostorm\Models\Mission;
use App\Evostorm\Models\MissionQueue;
use App\Evostorm\Models\MissionCost;
use App\Evostorm\Enums\MissionTypeEnum;
use App\Evostorm\Enums\MissionStatusEnum;
use Carbon\Carbon;
use Auth;
use DB;

class MissionsController extends Controller
{

    protected $missionsFacade;
    protected $missionsRepository;

    public function __construct(MissionsFacadeInterface $missionsFacade, MissionRepositoryInterface $missionRepository)
    {
        $this->missionsFacade = $missionsFacade;
        $this->missionsRepository = $missionRepository;
        $this->middleware('auth');
    }

    public function sendForCaptureMission($tile_id)
    {
        // Check if tile exists and belongs to authenticated user
        $tile = GameMap::where('id', $tile_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if (!$tile) {
            return $this->error("The given tile does not exist or you don't have permissions to it.");
        }

        if ($tile->species_amount == 0) {
            return $this->error("There is no individuals on this tile to capture.");
        }

        // Checking if there is a capture mission on this tile
        $mission = Mission::where('mission_type_id', MissionTypeEnum::CAPTURE_WORKERS)
            ->where('mission_status_id', MissionStatusEnum::IN_PROGRESS)
            ->where('tile_id', $tile->id)->first();
        if ($mission) {
            return $this->error("There is already a capture mission on this tile.");
        }


        $cost = MissionCost::find(MissionTypeEnum::CAPTURE_WORKERS);

        if (!$this->missionsFacade->checkEnoughResourcesForMission($cost, Auth::user())) {
            return $this->error("You don't have enough resources for this mission.");
        }

        DB::beginTransaction();

        $mission = new Mission();
        $mission->user_id = Auth::user()->id;
        $mission->mission_type_id = MissionTypeEnum::CAPTURE_WORKERS;
        $mission->mission_status_id = MissionStatusEnum::IN_PROGRESS;
        $mission->tile_id = $tile->id;

        if (!$mission->save()) {
            DB::rollback();
            return $this->error("The was an error during mission creation. Please try again later.");
        }

        // Updating resources
        $user = Auth::user();
        $user->amount_gold = $user->amount_gold - $cost->gold_cost;
        $user->amount_uranium = $user->amount_uranium - $cost->uranium_cost;
        $user->amount_kegrum = $user->amount_kegrum - $cost->kegrum_cost;
        if (!$user->save()) {
            DB::rollback();
            return $this->saveError();
        }

        $queue = new MissionQueue();
        $queue->mission_id = $mission->id;
        $queue->finish_time = Carbon::now('Europe/Warsaw')->addMinutes($cost->time_cost);
        if (!$queue->save()) {
            DB::rollback();
            return $this->error("The was an error during mission creation. Please try again later.");
        }

        DB::commit();

        return response()->json([
            'success' => "success"
        ]);
    }

    public function sendForResourcesEstimationMission($tile_id)
    {
        // Check if tile exists and belongs to authenticated user
        $tile = GameMap::where('id', $tile_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if (!$tile) {
            return $this->error("The given tile does not exist or you don't have permissions to it.");
        }

        if ($tile->is_estimated_resources) {
            return $this->error("The resources on this tile are already estimated.");
        }

        // Checking if there is a capture mission on this tile
        $mission = Mission::where('mission_type_id', MissionTypeEnum::ESTIMATE_RESOURCES)
            ->where('mission_status_id', MissionStatusEnum::IN_PROGRESS)
            ->where('tile_id', $tile->id)->first();
        if ($mission) {
            return $this->error("There is already an estimate resources mission on this tile.");
        }


        $cost = MissionCost::find(MissionTypeEnum::ESTIMATE_RESOURCES);

        if (!$this->missionsFacade->checkEnoughResourcesForMission($cost, Auth::user())) {
            return $this->error("You don't have enough resources for this mission.");
        }

        DB::beginTransaction();

        $mission = new Mission();
        $mission->user_id = Auth::user()->id;
        $mission->mission_type_id = MissionTypeEnum::ESTIMATE_RESOURCES;
        $mission->mission_status_id = MissionStatusEnum::IN_PROGRESS;
        $mission->tile_id = $tile->id;

        if (!$mission->save()) {
            DB::rollback();
            return $this->error("The was an error during mission creation. Please try again later.");
        }

        // Updating resources
        $user = Auth::user();
        $user->amount_gold = $user->amount_gold - $cost->gold_cost;
        $user->amount_uranium = $user->amount_uranium - $cost->uranium_cost;
        $user->amount_kegrum = $user->amount_kegrum - $cost->kegrum_cost;
        if (!$user->save()) {
            DB::rollback();
            return $this->saveError();
        }

        $queue = new MissionQueue();
        $queue->mission_id = $mission->id;
        $queue->finish_time = Carbon::now('Europe/Warsaw')->addMinutes($cost->time_cost);
        if (!$queue->save()) {
            DB::rollback();
            return $this->error("The was an error during mission creation. Please try again later.");
        }

        DB::commit();

        return response()->json([
            'success' => "success"
        ]);
    }

    public function getUserMissions()
    {
        $missions = $this->missionsRepository->findUserMissions(Auth::user()->id);
        $missionsInProgressArray = Array();
        $missionsEndedArray = Array();

        foreach ($missions as $m) {
            $o = (object)[];

            $tile = GameMap::find($m->tile_id);

            $o->id = $m->id;
            $o->status = $m->status->name;
            $o->type = $m->type->name;
            $o->started_date = $m->created_at;
            $o->finished_date = $m->finished_at;
            $o->result = $m->result;
            $o->tile_id = $m->tile_id;
            $o->tile_coord_x = $tile->coord_x;
            $o->tile_coord_y = $tile->coord_y;
            $o->will_finish_at_date = '';
            $mq = MissionQueue::where('mission_id', $m->id)->first();
            if ($mq) {
                $o->will_finish_at_date = $mq->finish_time;
            }

            if ($m->mission_status_id == MissionStatusEnum::IN_PROGRESS) {
                array_push($missionsInProgressArray, $o);
            } else {
                array_push($missionsEndedArray, $o);
            }
        }

        return response()->json([
                'missions_in_progress' => $missionsInProgressArray,
                'missions_ended' => $missionsEndedArray
            ]
        );

    }

    public function abortUserMission()
    {
        // TODO
    }

}
