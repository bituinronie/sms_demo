<?php

namespace App\Repositories\User\Auth;

use App\Repositories\BaseRepository;

use Carbon\Carbon, Arr;

use App\Models\User\UserAccount,
	App\Models\ActivityLog\ActivityLog;

class LoginUserRepository extends BaseRepository
{
    public function execute($request){

		$loginUser = [
			'employee_number' => $request->employeeNumber,
			'password'        => $request->password
		];
		
		if (!$token = auth('user')->attempt($loginUser)) {
			return $this->error("Incorrect Login Credentials");
		}

		$userAccount = UserAccount::findOrFail(auth('user')->user()->id); 
		
		$userAccount->update([
			"last_login" => Carbon::now()->toDateTimeString()
		]);
		
		$token = $this->respondWithToken($token);

		ActivityLog::create([
			"user_id" => $this->user()->id,
			"action"  => "LOGIN",
			"module"  => "USER",
			"message" => "LOGGED IN TO THE SYSTEM"
		]);

		return $this->success("Login Successful", Arr::collapse([ 
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