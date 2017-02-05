<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions;

class AuthController extends Controller
{
    //
    public function authenticate(Request $request){
        $cred = $request->only('username','password');

        try {
            if (! $token = JWTAuth::attempt($cred)){
                return response("Gagal",401);
            }
        } catch (Exceptions\JWTException $exceptione){
            return response("Ada yang salah :(", 500);
        }
        return response()->json(compact('token'));
    }
}
