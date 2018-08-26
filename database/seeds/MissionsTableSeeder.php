<?php

use Illuminate\Database\Seeder;
use App\Evostorm\Models\MissionType;
use App\Evostorm\Enums\MissionTypeEnum;
use App\Evostorm\Models\MissionStatus;
use App\Evostorm\Models\Cost;

class MissionsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cost = Cost::create(array(
            'gold' => 20,
            'uranium' => 0,
            'kegrum' => 0,
            'time' => 30
        ));
        MissionType::create(array(
                'id' => MissionTypeEnum::CAPTURE_WORKERS,
                'short_name' => 'CAPTURE_WORKERS',
                'name' => 'Capture workers from tile',
                'cost_id' => $cost->id)
        );

        $cost = Cost::create(array(
            'gold' => 30,
            'uranium' => 5,
            'kegrum' => 5,
            'time' => 20
        ));

        MissionType::create(array(
            'id' => MissionTypeEnum::ESTIMATE_RESOURCES,
            'short_name' => 'ESTIMATE_RESOURCES',
            'name' => 'Estimate tile\'s resources amount',
            'cost_id' => $cost->id
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
