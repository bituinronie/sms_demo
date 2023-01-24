<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

trait JwtAuth
{
    protected function user(){
        
        return auth('user')->user();
    }

    protected function student(){
        
        return auth('student')->user();
    }

    protected function respondWithToken($token){

        return $token = [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ];
    }

    
    protected function logoutMessage($message){

        return response()->json([
            'message' => $message
        ]);
    }
}