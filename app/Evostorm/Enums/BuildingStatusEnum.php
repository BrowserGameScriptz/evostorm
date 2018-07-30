<?php

namespace App\Evostorm\Enums;

/**
 * Description of BiuldingTypeEnum
 *
 * @author damianw
 */
abstract class BuildingStatusEnum {

    const BUILDING_IN_PROGRESS = 1;
    const OPERATIONAL = 2;
    const NON_OPERATIONAL = 3;
    const UPGRADE_IN_PROGRESS = 4;
    const DEMOLITION_IN_PROGRESS = 5;

}
