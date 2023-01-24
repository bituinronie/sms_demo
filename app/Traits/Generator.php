<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

use Carbon\Carbon;

use App\Models\Accounting\ProofOfPayment,
    App\Models\Employee\Employee,
    App\Models\Admission\ApplicantAdmission,
    App\Models\Schedule\Schedule;

trait Generator
{
    // *** Admission
    protected function priorityNumber($branchId){
        do {

            $yearId = implode(explode('20', Carbon::now()->year, 2));
            $random = random_int(100000, 999999);

            $priorityNumber = $branchId.$yearId.$random;

        } while (ApplicantAdmission::where("priority_number", "=", $priorityNumber)->first());

        return $priorityNumber;
	}
    

    // *** Proof of Payment
    protected function paymentCode(){
        do {

            $yearId = implode(explode('20', Carbon::now()->year, 2));
            $random = random_int(100000, 999999);

            $paymentCode = $yearId.$random;

        } while (ProofOfPayment::where("payment_code", "=", $paymentCode)->withTrashed()->first());
        
        return $paymentCode;
    }


    // *** Employee
    protected function employeeNumber(){
        do {
            
            $month  = Carbon::now()->month;
            $yearId = implode(explode('20', Carbon::now()->year, 2));
            $random = random_int(1000, 9999);

            $employeeNumber = str_pad($month, 2, '0', STR_PAD_LEFT).'-'.$yearId.'-'.$random;

        } while (Employee::where("employee_number", "=", $employeeNumber)->withTrashed()->first());
  
        return $employeeNumber;
	}


    // *** Schedule
    protected function classCode(){
        do {
            
            $yearId = implode(explode('20', Carbon::now()->year, 2));
            $random = random_int(10000, 99999);

            $code = $yearId.$random;

        } while (Schedule::where("code", "=", $code)->withTrashed()->first());
  
        return $code;
	}
}