<?php

namespace App\Http\Controllers\InformationTechnologyServices;

use App\Http\Controllers\Controller;

// * USER ACCOUNT REQUEST
use App\Http\Requests\InformationTechnologyServices\User\IndexUserAccountRequest,
    App\Http\Requests\InformationTechnologyServices\User\ListUserAccountRequest,
    App\Http\Requests\InformationTechnologyServices\User\ArchiveUserAccountRequest,
    App\Http\Requests\InformationTechnologyServices\User\RestoreUserAccountRequest,
    App\Http\Requests\InformationTechnologyServices\User\RegisterUserAccountRequest,
    App\Http\Requests\InformationTechnologyServices\User\ResetPasswordUserAccountRequest;

// * STUDENT ACCOUNT REQUEST
use App\Http\Requests\InformationTechnologyServices\Student\IndexStudentAccountRequest,
    App\Http\Requests\InformationTechnologyServices\Student\ListStudentAccountRequest,
    App\Http\Requests\InformationTechnologyServices\Student\ArchiveStudentAccountRequest,
    App\Http\Requests\InformationTechnologyServices\Student\RestoreStudentAccountRequest,
    App\Http\Requests\InformationTechnologyServices\Student\RegisterStudentAccountRequest,
    App\Http\Requests\InformationTechnologyServices\Student\ResetPasswordStudentAccountRequest;



// * USER ACCOUNT REPOSITORIES
use App\Repositories\InformationTechnologyServices\User\IndexUserAccountRepository,
    App\Repositories\InformationTechnologyServices\User\ListUserAccountRepository,
    App\Repositories\InformationTechnologyServices\User\ArchiveUserAccountRepository,
    App\Repositories\InformationTechnologyServices\User\RestoreUserAccountRepository,
    App\Repositories\InformationTechnologyServices\User\RegisterUserAccountRepository,
    App\Repositories\InformationTechnologyServices\User\ResetPasswordUserAccountRepository;

// * STUDENT ACCOUNT REPOSITORIES
use App\Repositories\InformationTechnologyServices\Student\IndexStudentAccountRepository,
    App\Repositories\InformationTechnologyServices\Student\ListStudentAccountRepository,
    App\Repositories\InformationTechnologyServices\Student\ArchiveStudentAccountRepository,
    App\Repositories\InformationTechnologyServices\Student\RestoreStudentAccountRepository,
    App\Repositories\InformationTechnologyServices\Student\RegisterStudentAccountRepository,
    App\Repositories\InformationTechnologyServices\Student\ResetPasswordStudentAccountRepository;

class InformationTechnologyServicesController extends Controller
{
    protected $indexUserAccount,
            $listUserAccount,
            $archiveUserAccount,
            $restoreUserAccount,
            $registerUserAccount,
            $resetPasswordUserAccount,

            $indexStudentAccount,
            $listStudentAccount,
            $archiveStudentAccount,
            $restoreStudentAccount,
            $registerStudentAccount,
            $resetPasswordStudentAccount;
    
    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexUserAccountRepository          $indexUserAccount,
        ListUserAccountRepository           $listUserAccount,
        ArchiveUserAccountRepository        $archiveUserAccount,
        RestoreUserAccountRepository        $restoreUserAccount,
        RegisterUserAccountRepository       $registerUserAccount,
        ResetPasswordUserAccountRepository  $resetPasswordUserAccount,

      
        IndexStudentAccountRepository         $indexStudentAccount,
        ListStudentAccountRepository          $listStudentAccount,
        ArchiveStudentAccountRepository       $archiveStudentAccount,
        RestoreStudentAccountRepository       $restoreStudentAccount,
        RegisterStudentAccountRepository      $registerStudentAccount,
        ResetPasswordStudentAccountRepository $resetPasswordStudentAccount
    ) {
        $this->indexUserAccount         = $indexUserAccount;
        $this->listUserAccount          = $listUserAccount;
        $this->archiveUserAccount       = $archiveUserAccount;
        $this->restoreUserAccount       = $restoreUserAccount;
        $this->registerUserAccount      = $registerUserAccount;
        $this->resetPasswordUserAccount = $resetPasswordUserAccount;

        $this->indexStudentAccount         = $indexStudentAccount;
        $this->listStudentAccount          = $listStudentAccount;
        $this->archiveStudentAccount       = $archiveStudentAccount;
        $this->restoreStudentAccount       = $restoreStudentAccount;
        $this->registerStudentAccount      = $registerStudentAccount;
        $this->resetPasswordStudentAccount = $resetPasswordStudentAccount;
    }
   

    //*********************************************** USER ***********************************************// 

    protected function indexUserAccount(IndexUserAccountRequest $request) {
        return $this->indexUserAccount->execute();
    }
    
    protected function listUserAccount(ListUserAccountRequest $request){
        return $this->listUserAccount->execute();
    }

    protected function archiveUserAccount(ArchiveUserAccountRequest $request, $employeeNumber){
        return $this->archiveUserAccount->execute($employeeNumber);
    }
    
    protected function restoreUserAccount(RestoreUserAccountRequest $request, $employeeNumber){
        return $this->restoreUserAccount->execute($employeeNumber);
    }

    protected function registerUserAccount(RegisterUserAccountRequest $request) {
        return $this->registerUserAccount->execute($request);
    }

    protected function resetPasswordUserAccount(ResetPasswordUserAccountRequest $request, $employeeNumber) {
        return $this->resetPasswordUserAccount->execute($employeeNumber);
    }


    //*********************************************** STUDENT ***********************************************// 

    protected function indexStudentAccount(IndexStudentAccountRequest $request) {
        return $this->indexStudentAccount->execute();
    }
    
    protected function listStudentAccount(ListStudentAccountRequest $request){
        return $this->listStudentAccount->execute();
    }

    protected function archiveStudentAccount(ArchiveStudentAccountRequest $request, $studentNumber){
        return $this->archiveStudentAccount->execute($studentNumber);
    }
    
    protected function restoreStudentAccount(RestoreStudentAccountRequest $request, $studentNumber){
        return $this->restoreStudentAccount->execute($studentNumber);
    }

    protected function registerStudentAccount(RegisterStudentAccountRequest $request) {
        return $this->registerStudentAccount->execute($request);
    }

    protected function resetPasswordStudentAccount(ResetPasswordStudentAccountRequest $request, $studentNumber) {
        return $this->resetPasswordStudentAccount->execute($studentNumber);
    }
}
