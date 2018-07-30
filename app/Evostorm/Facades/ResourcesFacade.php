<?php

namespace App\Evostorm\Facades;

use App\Evostorm\Models\User;
use App\Evostorm\Enums\GameConfigEnum;
use App\Evostorm\Models\GameConfig;

/**
 * Description of ResourcesFacade
 *
 * @author damian
 */
class ResourcesFacade {

    public function assignStartingResources(User $user) {
        $user->amount_gold = GameConfig::find(GameConfigEnum::RESOURCE_GOLD_STARTING_AMOUNT)->value;
        $user->amount_uranium = GameConfig::find(GameConfigEnum::RESOURCE_URANIUM_STARTING_AMOUNT)->value;
        $user->amount_food = GameConfig::find(GameConfigEnum::RESOURCE_FOOD_STARTING_AMOUNT)->value;
        $user->amount_workforce = GameConfig::find(GameConfigEnum::RESOURCE_WORKFORCE_STARTING_AMOUNT)->value;
        $user->amount_kegrum = GameConfig::find(GameConfigEnum::RESOURCE_KEGRUM_STARTING_AMOUNT)->value;

        $resource_gold_starting_income_ammount = GameConfig::find(GameConfigEnum::RESOURCE_GOLD_STARTING_INCOME_AMOUNT)->value;
        $resource_uranium_starting_income_ammount = GameConfig::find(GameConfigEnum::RESOURCE_URANIUM_STARTING_INCOME_AMOUNT)->value;
        $resource_food_starting_income_ammount = GameConfig::find(GameConfigEnum::RESOURCE_FOOD_STARTING_INCOME_AMOUNT)->value;
        $resource_workforce_starting_income_ammount = GameConfig::find(GameConfigEnum::RESOURCE_WORKFORCE_STARTING_INCOME_AMOUNT)->value;
        $resource_kegrum_starting_income_ammount = GameConfig::find(GameConfigEnum::RESOURCE_KEGRUM_STARTING_INCOME_AMOUNT)->value;

        $resource_gold_starting_outcome_ammount = GameConfig::find(GameConfigEnum::RESOURCE_GOLD_STARTING_OUTCOME_AMOUNT)->value;
        $resource_uranium_starting_outcome_ammount = GameConfig::find(GameConfigEnum::RESOURCE_URANIUM_STARTING_OUTCOME_AMOUNT)->value;
        $resource_food_starting_outcome_ammount = GameConfig::find(GameConfigEnum::RESOURCE_FOOD_STARTING_OUTCOME_AMOUNT)->value;
        $resource_workforce_starting_outcome_ammount = GameConfig::find(GameConfigEnum::RESOURCE_WORKFORCE_STARTING_OUTCOME_AMOUNT)->value;
        $resource_kegrum_starting_outcome_ammount = GameConfig::find(GameConfigEnum::RESOURCE_KEGRUM_STARTING_OUTCOME_AMOUNT)->value;

        $user->income_gold = $resource_gold_starting_income_ammount;
        $user->income_uranium = $resource_uranium_starting_income_ammount;
        $user->income_food = $resource_food_starting_income_ammount;
        $user->income_workforce = $resource_workforce_starting_income_ammount;
        $user->income_kegrum = $resource_kegrum_starting_income_ammount;

        $user->outcome_gold = $resource_gold_starting_outcome_ammount;
        $user->outcome_uranium = $resource_uranium_starting_outcome_ammount;
        $user->outcome_food = $resource_food_starting_outcome_ammount;
        $user->outcome_workforce = $resource_workforce_starting_outcome_ammount;
        $user->outcome_kegrum = $resource_kegrum_starting_outcome_ammount;

        $user->balance_gold = $resource_gold_starting_income_ammount - $resource_gold_starting_outcome_ammount;
        $user->balance_uranium = $resource_uranium_starting_income_ammount - $resource_uranium_starting_outcome_ammount;
        $user->balance_food = $resource_food_starting_income_ammount - $resource_food_starting_outcome_ammount;
        $user->balance_workforce = $resource_workforce_starting_income_ammount - $resource_workforce_starting_outcome_ammount;
        $user->balance_kegrum = $resource_kegrum_starting_income_ammount - $resource_kegrum_starting_outcome_ammount;

        $user->save();
    }

}
