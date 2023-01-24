<?php

namespace App\Repositories\Student\Auth;

use App\Repositories\BaseRepository;

use Carbon\Carbon, Arr;

use App\Models\Student\StudentAccount,
	App\Models\ActivityLog\ActivityLog;

class LoginStudentRepository extends BaseRepository
{
    public function execute($request){

		$loginStudent = [
			'student_number' => $request->studentNumber,
			'password'       => $request->password
		];
		
		if (!$token = auth('student')->attempt($loginStudent)) {
			return $this->error("Incorrect Login Credentials");
		}

		$studentAccount = StudentAccount::findOrFail($this->student()->id); 
		
		$studentAccount->update([
			"last_login" => Carbon::now()->toDateTimeString()
		]);
		
		$token = $this->respondWithToken($token);

		ActivityLog::create([
			"student_id" => $this->student()->id,
			"action"     => "LOGIN",
			"module"     => "STUDENT",
			"message"    => "LOGGED IN TO THE PORTAL"
		]);

		return $this->success("Login Successful", Arr::collapse([
			[
				"lastLogin"         => $this->student()->last_login,
				"accountBranchName" => $this->student()->personal->admission->branch->name,
				"accountBranchCode" => $this->student()->personal->admission->branch->code,
				"accountBranchType" => $this->student()->personal->admission->branch->type,
				"accountRole"       => $this->student()->getRoleNames()
			],
			$token
		]));
	}
}