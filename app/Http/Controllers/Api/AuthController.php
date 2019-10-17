<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use JwtAuth;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ValidateAndCreatePatient;

class AuthController extends Controller
{
    use ValidateAndCreatePatient;

    public function login(Request $request){
        //return "hola";
        // return $request->only('email', 'password');
        //return 'publico';
        $credentials = $request->only("email", "password");
        
        if( Auth::guard('api')->attempt($credentials) ){
            $user = Auth::guard('api')->user();
            $jwt = JwtAuth::generateToken($user);
            //$error = false;
            $success = true;

            //$data = compact('user', 'jwt');
            //return compact('error', 'data');
            return compact('success', 'user', 'jwt');
            // return successfull sign in response with the generated jwt
        } else {
            // return response for failed attempt
            //$error = true;
            $success = false;
            $message = 'Invalida Credencial';
            return compact('success', 'message');
        }
        
        
    }

    public function logout(){
        Auth::guard('api')->logout();
        $success = true;
        return compact('success');
    }

    public function register(Request $request){
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        Auth::guard('api')->login($user);

        $jwt = JwtAuth::generateToken($user);
        $success = true;
        return compact('success', 'user', 'jwt');
    }

}
