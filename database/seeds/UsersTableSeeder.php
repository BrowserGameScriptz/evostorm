<?php

use Illuminate\Database\Seeder;
use App\Evostorm\Facades\Contracts\TilesFacadeInterface;
use App\Evostorm\Facades\Contracts\ResourcesFacadeInterface;
use App\Evostorm\Repositories\UserRepositoryInterface;

class UsersTableSeeder extends Seeder
{

    protected $tilesFacade, $resourcesFacade;
    protected $userRepository;

    public function __construct(TilesFacadeInterface $tilesFacade,
                                ResourcesFacadeInterface $resourcesFacade,
                                UserRepositoryInterface $userRepository)
    {
        $this->tilesFacade = $tilesFacade;
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

        $this->tilesFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);

        $user = $this->userRepository->create([
            'name' => "tim",
            'email' => 'tim@gotae.com',
            'password' => 'password',
        ]);

        $this->tilesFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);

        $user = $this->userRepository->create([
            'name' => "jim",
            'email' => 'jim@gotae.com',
            'password' => 'password',
        ]);

        $this->tilesFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);
    }

}
