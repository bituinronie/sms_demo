<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Student\Auth\LoginRequest,
    App\Http\Requests\Student\Auth\ChangePasswordRequest;


// * REPOSITORIES
use App\Repositories\Student\Auth\LoginStudentRepository,
    App\Repositories\Student\Auth\LogoutStudentRepository,
    App\Repositories\Student\Auth\RefreshStudentRepository,
    App\Repositories\Student\Auth\ChangePasswordStudentRepository;

class AuthStudentController extends Controller
{
    protected $login, $logout, $refreshToken;
    
    // * CONSTRUCTOR INJECTION
    public function __construct(
        LoginStudentRepository          $login, 
        LogoutStudentRepository         $logout,
        RefreshStudentRepository        $refreshToken,
        ChangePasswordStudentRepository $changePassword
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
