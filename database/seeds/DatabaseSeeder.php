<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GameConfigSeeder::class);
        $this->call(TileTypeSeeder::class);
        $this->call(GameMapSeeder::class);
        $this->call(BuildingSeeder::class);
        $this->call(BuildingLevelsTableSeeder::class);
        $this->call(BuildingsTypesAllowedTileTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SpeciesTablesSeeder::class);
        $this->call(GameMapSpeciesSeeder::class);
        $this->call(MissionsTableSeeder::class);
    }
}
