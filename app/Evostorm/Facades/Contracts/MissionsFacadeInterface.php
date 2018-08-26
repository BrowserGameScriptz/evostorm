<?php

namespace App\Evostorm\Facades\Contracts;

interface MissionsFacadeInterface
{
    public function checkIfMissionFails($missionType);
}