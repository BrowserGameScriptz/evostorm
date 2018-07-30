<?php

namespace App\Config;

/**
 * Description of MissionConfigEnum
 *
 * @author damianw
 */
abstract class MissionConfigEnum
{

    const MAX_PROB = 1000;
    const CAPTURE_WORKERS_FAILS_PROBABILITY = 10; // per 1000
    const ESTIMATE_RESOURCES_FAILS_PROBABILITY = 5; // per 1000

}
