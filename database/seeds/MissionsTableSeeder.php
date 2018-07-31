<?php

use Illuminate\Database\Seeder;
use App\Evostorm\Models\MissionType;
use App\Evostorm\Enums\MissionTypeEnum;
use App\Evostorm\Models\MissionCost;
use App\Evostorm\Models\MissionStatus;

class MissionsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MissionType::create(array(
            'id' => MissionTypeEnum::CAPTURE_WORKERS,
            'short_name' => 'CAPTURE_WORKERS',
            'name' => 'Capture workers from tile'));

        MissionCost::create(array(
            'mission_type_id' => MissionTypeEnum::CAPTURE_WORKERS,
            'gold_cost' => 20,
            'uranium_cost' => 0,
            'kegrum_cost' => 0,
            'time_cost' => 30
        ));

        MissionType::create(array(
            'id' => MissionTypeEnum::ESTIMATE_RESOURCES,
            'short_name' => 'ESTIMATE_RESOURCES',
            'name' => 'Estimate tile\'s resources amount'));

        MissionCost::create(array(
            'mission_type_id' => MissionTypeEnum::ESTIMATE_RESOURCES,
            'gold_cost' => 30,
            'uranium_cost' => 5,
            'kegrum_cost' => 5,
            'time_cost' => 20
        ));

        MissionStatus::create(array(
            'id' => 1,
            'short_name' => 'IN_PROGRESS',
            'name' => 'In progress'
        ));

        MissionStatus::create(array(
            'id' => 2,
            'short_name' => 'COMPLETED',
            'name' => 'Completed'
        ));

        MissionStatus::create(array(
            'id' => 3,
            'short_name' => 'ABORTED',
            'name' => 'Aborted'
        ));

        MissionStatus::create(array(
            'id' => 4,
            'short_name' => 'FAILED',
            'name' => 'Aborted'
        ));
    }

}
