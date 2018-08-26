<?php

namespace App\Evostorm\Facades;

use App\Evostorm\Facades\Contracts\MissionsFacadeInterface;
use App\Evostorm\Models\Cost;
use App\Evostorm\Models\User;
use DB;
use App\Evostorm\Enums\MissionTypeEnum;
use App\Config\MissionConfigEnum;

/**
 * Description of ResourcesFacade
 *
 * @author damian
 */
class MissionsFacade implements MissionsFacadeInterface
{
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
