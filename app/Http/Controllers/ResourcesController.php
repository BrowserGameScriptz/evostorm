<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

/**
 * Description of ResourcesController
 *
 * @author damian
 */
class ResourcesController extends Controller {

    public function getUsersCurrentResources() {
        $user = Auth::user();
        return response()->json([
                    'amount_gold' => $user->amount_gold,
                    'amount_uranium' => $user->amount_uranium,
                    'amount_food' => $user->amount_food,
                    'amount_workforce' => $user->amount_workforce,
                    'amount_kegrum' => $user->amount_kegrum,
                    'income_gold' => $user->income_gold,
                    'income_uranium' => $user->income_uranium,
                    'income_food' => $user->income_food,
                    'income_workforce' => $user->income_workforce,
                    'income_kegrum' => $user->income_kegrum,
                    'outcome_gold' => $user->outcome_gold,
                    'outcome_uranium' => $user->outcome_uranium,
                    'outcome_food' => $user->outcome_food,
                    'outcome_workforce' => $user->outcome_workforce,
                    'outcome_kegrum' => $user->outcome_kegrum,
                    'balance_gold' => $user->balance_gold,
                    'balance_uranium' => $user->balance_uranium,
                    'balance_food' => $user->balance_food,
                    'balance_workforce' => $user->balance_workforce,
                    'balance_kegrum' => $user->balance_kegrum,
                    'energy_production' => $user->energy_production,
                    'energy_consumption' => $user->energy_consumption
        ]);
    }

}
