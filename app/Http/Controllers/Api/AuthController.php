<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use JwtAuth;

class AuthController extends Controller
{
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
            $message = 'Invalid credentials';
            return compact('success', 'message');
        }
        
        
    }

    public function logout(){
        Auth::guard('api')->logout();
        $success = true;
        return compact('success');
    }
}
