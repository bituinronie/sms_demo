<?php

namespace App\Repositories\Student\Auth;

use App\Repositories\BaseRepository;

use Hash, Arr;

use App\Models\Student\StudentAccount,
	App\Models\ActivityLog\ActivityLog;

class ChangePasswordStudentRepository extends BaseRepository
{
    public function execute($request){

		$studentAccount = StudentAccount::where('student_number', '=', $this->student()->student_number)->firstOrFail();
		$studentNumber  = $this->student()->student_number;

		$credentials = [
			'student_number' => $studentNumber,
			'password'       => $request->oldPassword
		];

		if (!auth('student')->validate($credentials)) {
			return $this->error("Incorrect Old Password");
		}

		auth('student')->invalidate();

		$studentAccount->update([
			'password' => Hash::make($request->password)
		]);

		$loginStudent = [
			'student_number' => $studentNumber,
			'password'       => $request->password
		];
		
		$token = $this->respondWithToken(auth('student')->attempt($loginStudent));

		ActivityLog::create([
			"student_id" => $this->student()->id,
			"action"     => "UPDATE",
			"module"     => "STUDENT",
			"message"    => "CHANGED ACCOUNT PASSWORD"
		]);

		return $this->success("Student Password Successfully Changed", Arr::collapse([
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