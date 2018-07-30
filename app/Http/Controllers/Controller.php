<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function error($error_message)
    {
        return response()->json([
            'error' => $error_message
        ]);
    }

    protected function saveError($error_message)
    {
        return response()->json([
            'error' => "There was an error saving data. Please try again later." . $error_message
        ]);
    }
}
