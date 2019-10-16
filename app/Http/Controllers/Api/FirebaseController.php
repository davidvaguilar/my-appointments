<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FirebaseController extends Controller
{
    public function postToken(Request  $resquest){
        $user = Auth::guard('api')->user();
        if( $request->has('device_token') ){
            $user->device_token = $request->input('device_token');
            $user->save();
        }
        
            
    }
}
