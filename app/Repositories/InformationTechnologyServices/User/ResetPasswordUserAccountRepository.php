<?php

namespace App\Repositories\InformationTechnologyServices\User;

use App\Repositories\BaseRepository;

use Str, Hash;

use App\Models\User\UserAccount,
	App\Models\ActivityLog\ActivityLog;

class ResetPasswordUserAccountRepository extends BaseRepository
{
    public function execute($employeeNumber){

		// *** Reset only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$password = Str::random(8);

			$userAccount  = UserAccount::where('employee_number', '=', $employeeNumber)->firstOrFail();

			$userAccount->update([
				'password' => Hash::make($password)
			]);

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "UPDATE",
				"module"  => "INFORMATION TECHNOLOGY SERVICE",
				"message" => "RESET AN EMPLOYEE USER ACCOUNT PASSWORD",
				"causeTo" => [
					"EMPLOYEE NUMBER" => $userAccount->employee->employee_number,
					"FULL NAME"       => "{$userAccount->employee->last_name}, {$userAccount->employee->first_name}".($userAccount->employee->middle_name ? ' '.$userAccount->employee->middle_name:''),
					"TYPE"            => $userAccount->employee->type,
					"DEPARTMENT"      => $userAccount->employee->department->name,
					"BRANCH"          => $userAccount->employee->branch->name
				]
			]);

			$this->sendResetUserPassword(
				$employeeNumber,
				$userAccount->employee->first_name,
				$password,
				$userAccount->employee->email_address
			);

			return $this->success("User Account Password Successfully Reset", ["employeeNumber" => $userAccount->employee->employee_number]);

		} else {

			return $this->error("You're not authorized to reset the password of this user");
		}
	}
}