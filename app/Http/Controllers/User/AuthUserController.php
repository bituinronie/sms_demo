<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\User\Auth\LoginRequest,
    App\Http\Requests\User\Auth\ChangePasswordRequest;

    
// * REPOSITORIES
use App\Repositories\User\Auth\LoginUserRepository,
    App\Repositories\User\Auth\LogoutUserRepository,
    App\Repositories\User\Auth\RefreshUserRepository,
    App\Repositories\User\Auth\ChangePasswordUserRepository;
    

class AuthUserController extends Controller
{
    protected $login, $logout, $refreshToken;
    
    // * CONSTRUCTOR INJECTION
    public function __construct(
        LoginUserRepository          $login, 
        LogoutUserRepository         $logout,
        RefreshUserRepository        $refreshToken,
        ChangePasswordUserRepository $changePassword
    ) {
        $this->login          = $login;
        $this->logout         = $logout;
        $this->refreshToken   = $refreshToken;
        $this->changePassword = $changePassword;
    }
 
    
    protected function login(LoginRequest $request){
        return $this->login->execute($request);
    }

    protected function logout(){
        return $this->logout->execute();
    }

    protected function refresh(){
        return $this->refreshToken->execute();
    }

    protected function changePassword(ChangePasswordRequest $request){
        return $this->changePassword->execute($request);
    }
}
