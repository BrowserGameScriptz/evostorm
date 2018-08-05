<?php

namespace App\Evostorm\Facades\Contracts;


use App\Evostorm\Models\MissionCost;
use App\Evostorm\Models\User;

interface MissionsFacadeInterface
{
    public function checkEnoughResourcesForMission(MissionCost $cost, User $user);

    public function checkIfMissionFails($missionType);
}