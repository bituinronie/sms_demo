<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Admission\Online\CreateOnlineAdmissionRequest,
    App\Http\Requests\Admission\Online\OnlineAdmissionRequest,   
    App\Http\Requests\Admission\Miscellaneous\EmailValidationAdmissionRequest;


// * REPOSITORIES
use App\Repositories\Admission\CreateAdmissionRepository,
    App\Repositories\Admission\Miscellaneous\OnlineAdmissionRepository,
    App\Repositories\Admission\Miscellaneous\EmailValidationAdmissionRepository;


class OnlineApplicantController extends Controller
{
    protected $create, $online, $emailValidation;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        CreateAdmissionRepository          $create, 
        OnlineAdmissionRepository          $online, 
        EmailValidationAdmissionRepository $emailValidation
    ){
        $this->create          = $create;
        $this->online          = $online;
        $this->emailValidation = $emailValidation;
    }

    
    protected function online(OnlineAdmissionRequest $request, $branchCode = null, $type = null){
        return $this->online->execute($branchCode, $type);
    }


    protected function create(CreateOnlineAdmissionRequest $request){
        return $this->create->execute($request);
    }


    protected function emailValidation(EmailValidationAdmissionRequest $request){
        return $this->emailValidation->execute();
    }
}
