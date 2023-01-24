<?php

namespace App\Repositories\User\Auth;

use App\Repositories\BaseRepository;

use Hash, Arr;

use App\Models\User\UserAccount,
	App\Models\ActivityLog\ActivityLog;

class ChangePasswordUserRepository extends BaseRepository
{
    public function execute($request){

		$userAccount  = UserAccount::where('employee_number', '=', $this->user()->employee_number)->firstOrFail();
		$employeeNumber  = $this->user()->employee_number;

		$credentials = [
			'employee_number' => $employeeNumber,
			'password'        => $request->oldPassword
		];

		if (!auth('user')->validate($credentials)) {
			return $this->error("Incorrect Old Password");
		}

		auth('user')->invalidate();

		$userAccount->update([
			'password' => Hash::make($request->password)
		]);

		$loginUser = [
			'employee_number' => $employeeNumber,
			'password'        => $request->password
		];

		$token = $this->respondWithToken(auth('user')->attempt($loginUser));

		ActivityLog::create([
			"user_id" => $this->user()->id,
			"action"  => "UPDATE",
			"module"  => "USER",
			"message" => "CHANGED ACCOUNT PASSWORD"
		]);

		return $this->success("User Password Successfully Changed", Arr::collapse([ 
			[
				"lastLogin"         => $this->user()->last_login,
				"accountBranchName" => $this->user()->employee->branch->name,
				"accountBranchCode" => $this->user()->employee->branch->code,
				"accountBranchType" => $this->user()->employee->branch->type,
				"accountRole"       => $this->user()->getRoleNames()
			],
			$token
		]));
	}
}