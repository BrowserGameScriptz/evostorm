<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Facades\GameMapFacade;
use App\Facades\ResourcesFacade;

class UsersTableSeeder extends Seeder {

    protected $gameMapFacade, $resourcesFacade;

    public function __construct(GameMapFacade $gameMapFacade, ResourcesFacade $resourcesFacade) {
        $this->gameMapFacade = $gameMapFacade;
        $this->resourcesFacade = $resourcesFacade;
    }

    public function run() {
        $user = User::create([
                    'id' => 1,
                    'name' => "God",
                    'email' => 'god@gotae.com',
                    'password' => bcrypt('password'),
        ]);

        $user = User::create([
                    'name' => "damianw",
                    'email' => 'd.m.winiarski@gmail.com',
                    'password' => bcrypt('password'),
        ]);

        $this->gameMapFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);

        $user = User::create([
                    'name' => "tim",
                    'email' => 'tim@gotae.com',
                    'password' => bcrypt('password'),
        ]);

        $this->gameMapFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);

        $user = User::create([
                    'name' => "jim",
                    'email' => 'jim@gotae.com',
                    'password' => bcrypt('password'),
        ]);

        $this->gameMapFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);
    }

//put your code here
}
