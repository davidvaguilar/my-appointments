<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Traits\ValidateAndCreatePatient;

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
    use ValidateAndCreatePatient;  //Nuevo Traits

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

 /*   protected function validator(array $data)
    {
        return Validator::make($data, User::$rules);
*/
        /* [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]*/
   /* }

    protected function create(array $data)
    {
        return User::createPatient($data);
    }*/
}
