<?php

use Illuminate\Database\Seeder;
use App\Evostorm\Models\TileType;

class TileTypeSeeder extends Seeder {

    public function run() {
        TileType::create(array("id" => 1, "name" => "PLAIN"));
        TileType::create(array("id" => 2, "name" => "FOREST"));
        TileType::create(array("id" => 3, "name" => "MOUNTAINS"));
        TileType::create(array("id" => 4, "name" => "HILLS"));
        TileType::create(array("id" => 5, "name" => "WATER"));
    }

}
