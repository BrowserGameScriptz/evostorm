<?php

namespace App\Evostorm\Facades;

use App\Evostorm\Models\MissionCost;
use App\Evostorm\Models\User;
use DB;
use App\Evostorm\Enums\MissionTypeEnum;
use App\Config\MissionConfigEnum;

/**
 * Description of ResourcesFacade
 *
 * @author damian
 */
class MissionsFacade
{

    public function checkEnoughResourcesForMission(MissionCost $cost, User $user)
    {
        if ((($user->amount_gold - $cost->gold_cost) < 0) || (($user->amount_uranium - $cost->uranium_cost) < 0) || (($user->amount_kegrum - $cost->kegrum_cost) < 0)
        ) {
            return false;
        } else {
            return true;
        }
    }

    public function checkIfMissionFails($missionType)
    {
        switch ($missionType) {
            case MissionTypeEnum::CAPTURE_WORKERS:
                if (rand(0, MissionConfigEnum::MAX_PROB) <= MissionConfigEnum::CAPTURE_WORKERS_FAILS_PROBABILITY) {
                    return true;
                } else {
                    return false;
                }
            case MissionTypeEnum::ESTIMATE_RESOURCES:
                if (rand(0, MissionConfigEnum::MAX_PROB) <= MissionConfigEnum::ESTIMATE_RESOURCES_FAILS_PROBABILITY) {
                    return true;
                } else {
                    return false;
                }
            default:
                return false;
        }
    }

}
