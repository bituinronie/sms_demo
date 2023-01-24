<?php

namespace App\Repositories\InformationTechnologyServices\User;

use App\Repositories\BaseRepository;

use Hash, Role;

use App\Models\User\UserAccount,
	App\Models\ActivityLog\ActivityLog;

class RegisterUserAccountRepository extends BaseRepository
{
    public function execute($request){

		// *** Create only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$userAccount = UserAccount::create([
				'employee_id'     => $this->getEmployeeId($request->employeeNumber),
				'name'            => strtoupper($request->name),
				'employee_number' => $request->employeeNumber,
				'password'        => Hash::make($request->password)
			]);

			$role = Role::findByName($request->role);

			$userAccount->assignRole($role);

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "CREATE",
				"module"  => "INFORMATION TECHNOLOGY SERVICE",
				"message" => "REGISTERED A EMPLOYEE USER ACCOUNT",
				"data"    => 
				[
					"new" => [
						"EMPLOYEE NUMBER" => $userAccount->employee->employee_number,
						"FULL NAME"       => "{$userAccount->employee->last_name}, {$userAccount->employee->first_name}".($userAccount->employee->middle_name ? ' '.$userAccount->employee->middle_name:''),
						"TYPE"            => $userAccount->employee->type,
						"DEPARTMENT"      => $userAccount->employee->department->name,
						"BRANCH"          => $userAccount->employee->branch->name
					]
				]
			]);

			return $this->success("Employee Account Successfully Created", ["employeeNumber" => $userAccount->employee->employee_number]);

		} else {

			return $this->error("You're not authorized to register a user");
		}
	}
}