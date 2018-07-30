<?php

namespace App\Http\Controllers\Auth;

use App\Evostorm\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Evostorm\Facades\GameMapFacade;
use App\Evostorm\Facades\ResourcesFacade;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $gameMapFacade, $resourcesFacade;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GameMapFacade $gameMapFacade, ResourcesFacade $resourcesFacade)
    {
        $this->gameMapFacade = $gameMapFacade;
        $this->resourcesFacade = $resourcesFacade;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);


        $this->gameMapFacade->assignRandomTerrain($user);
        $this->resourcesFacade->assignStartingResources($user);

        return $user;
    }
}
