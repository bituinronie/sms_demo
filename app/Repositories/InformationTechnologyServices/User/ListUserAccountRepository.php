<?php

namespace App\Repositories\InformationTechnologyServices\User;

use App\Repositories\BaseRepository;

use App\Models\User\UserAccount;

class ListUserAccountRepository extends BaseRepository
{
    public function execute() {

		// *** Show all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$userAccount = UserAccount::onlyTrashed()->
            join(
				'employees', 
				'employees.id', '=', 
				'user_accounts.employee_id'
			)->get();
			
		}
		// *** Show current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$userAccount = UserAccount::onlyTrashed()->
            join(
				'employees',
				'employees.id', '=',
				'user_accounts.employee_id'
			)->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all user account");
			
		}

		return $this->success("List of All User Account", $this->listUserAccount($userAccount));
    }


    //*********************************************** CUSTOM FUNCTION ***********************************************//
    
    private function listUserAccount($employee){

		foreach($employee as $key => $value){
			$data[$key] = [
				"employeeNumber" => $value->employee_number,
				"lastName"       => $value->last_name,
				"firstName"      => $value->first_name,
				"middleName"     => $value->middle_name,
				"type"           => $value->type,
				"department"     => $value->employee->department->name,
				"branch"         => $value->employee->branch->name
			];
		}

		return $data ?? [];
    }
}