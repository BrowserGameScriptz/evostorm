<?php

use Illuminate\Database\Seeder;
use App\Evostorm\Facades\Contracts\GameMapFacadeInterface;
use App\Evostorm\Facades\Contracts\ResourcesFacadeInterface;
use App\Evostorm\Repositories\UserRepositoryInterface;

class UsersTableSeeder extends Seeder
{

    protected $gameMapFacade, $resourcesFacade;
    protected $userRepository;

    public function __construct(GameMapFacadeInterface $gameMapFacade,
                                ResourcesFacadeInterface $resourcesFacade,
                                UserRepositoryInterface $userRepository)
    {
        $this->gameMapFacade = $gameMapFacade;
        $this->resourcesFacade = $resourcesFacade;
        $this->userRepository = $userRepository;
    }

    public function run()
    {
        $this->userRepository->create([
            'id' => 1,
            'name' => "God",
            'email' => 'god@gotae.com',
            'password' => 'password',
        ]);

        $user = $this->userRepository->create([
            'name' => "damianw",
            'email' => 'd.m.winiarski@gmail.com',
            'password' => 'password',
        ]);

        $this->gameMapFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);

        $user = $this->userRepository->create([
            'name' => "tim",
            'email' => 'tim@gotae.com',
            'password' => 'password',
        ]);

        $this->gameMapFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);

        $user = $this->userRepository->create([
            'name' => "jim",
            'email' => 'jim@gotae.com',
            'password' => 'password',
        ]);

        $this->gameMapFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);
    }

}
