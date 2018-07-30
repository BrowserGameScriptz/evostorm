<?php

use Illuminate\Database\Seeder;
use App\Models\GameConfig;

class GameConfigSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameConfig::create(array("id" => 1, "param" => "MAP_X_SIZE", "value" => 200));
        GameConfig::create(array("id" => 2, "param" => "MAP_Y_SIZE", "value" => 200));
        GameConfig::create(array("id" => 3, "param" => "USER_MAP_WIDTH", "value" => 10));
        GameConfig::create(array("id" => 4, "param" => "USER_MAP_HEIGHT", "value" => 10));

        GameConfig::create(array("id" => 5, "param" => "RESOURCE_GOLD_STARTING_AMOUNT", "value" => 1500));
        GameConfig::create(array("id" => 6, "param" => "RESOURCE_URANIUM_STARTING_AMOUNT", "value" => 1200));
        GameConfig::create(array("id" => 7, "param" => "RESOURCE_FOOD_STARTING_AMOUNT", "value" => 1250));
        GameConfig::create(array("id" => 8, "param" => "RESOURCE_WORKFORCE_STARTING_AMOUNT", "value" => 0));
        GameConfig::create(array("id" => 9, "param" => "RESOURCE_KEGRUM_STARTING_AMOUNT", "value" => 1200));

        GameConfig::create(array("id" => 10, "param" => "RESOURCE_GOLD_STARTING_INCOME_AMOUNT", "value" => 0));
        GameConfig::create(array("id" => 11, "param" => "RESOURCE_URANIUM_STARTING_INCOME_AMOUNT", "value" => 0));
        GameConfig::create(array("id" => 12, "param" => "RESOURCE_FOOD_STARTING_INCOME_AMOUNT", "value" => 0));
        GameConfig::create(array("id" => 13, "param" => "RESOURCE_WORKFORCE_STARTING_INCOME_AMOUNT", "value" => 0));
        GameConfig::create(array("id" => 14, "param" => "RESOURCE_KEGRUM_STARTING_INCOME_AMOUNT", "value" => 0));

        GameConfig::create(array("id" => 15, "param" => "RESOURCE_GOLD_STARTING_OUTCOME_AMOUNT", "value" => 5));
        GameConfig::create(array("id" => 16, "param" => "RESOURCE_URANIUM_STARTING_OUTCOME_AMOUNT", "value" => 20));
        GameConfig::create(array("id" => 17, "param" => "RESOURCE_FOOD_STARTING_OUTCOME_AMOUNT", "value" => 15));
        GameConfig::create(array("id" => 18, "param" => "RESOURCE_WORKFORCE_STARTING_OUTCOME_AMOUNT", "value" => 0));
        GameConfig::create(array("id" => 19, "param" => "RESOURCE_KEGRUM_STARTING_OUTCOME_AMOUNT", "value" => 0));

        GameConfig::create(array("id" => 20, "param" => "USER_MAP_TILE_RADIUS", "value" => 60));
    }

}
