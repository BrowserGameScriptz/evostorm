<?php

namespace Tests\Unit;

use App\Evostorm\Facades\UsersFacade;
use App\Evostorm\Models\Cost;
use App\Evostorm\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersFacadeTest extends TestCase
{

    protected $usersFacade;
    protected $user;

    protected function setUp()
    {
        $this->user = new User();
        $this->user->amount_gold = 1500;
        $this->user->amount_uranium = 1000;
        $this->user->amount_kegrum = 500;

        $this->usersFacade = new UsersFacade();
    }

    /**
     * @test
     */
    public function user_has_not_enough_gold()
    {
        $cost = new Cost();
        $cost->gold = 3000;
        $cost->uranium = 300;
        $cost->kegrum = 120;
        $cost->time = 5;
        $this->assertFalse($this->usersFacade->checkHasEnoughResources($this->user, $cost));
    }

    /**
     * @test
     */
    public function user_has_not_enough_uranium()
    {
        $cost = new Cost();
        $cost->gold = 1500;
        $cost->uranium = 1100;
        $cost->kegrum = 120;
        $cost->time = 5;
        $this->assertFalse($this->usersFacade->checkHasEnoughResources($this->user, $cost));
    }

    /**
     * @test
     */
    public function user_has_not_enough_kegrum()
    {
        $cost = new Cost();
        $cost->gold = 1500;
        $cost->uranium = 900;
        $cost->kegrum = 600;
        $cost->time = 5;
        $this->assertFalse($this->usersFacade->checkHasEnoughResources($this->user, $cost));
    }

    /**
     * @test
     */
    public function user_has_enough_resources()
    {
        $cost = new Cost();
        $cost->gold = 60;
        $cost->uranium = 170;
        $cost->kegrum = 120;
        $cost->time = 5;
        $this->assertTrue($this->usersFacade->checkHasEnoughResources($this->user, $cost));
    }

}
