<?php

// *** CREATED BY: Jim Kier Mesa

namespace App\Traits;

use Mail;

use App\Mail\Admission\TemporaryAccount,
	App\Mail\Admission\ApplicantStatus,
	App\Mail\InformationTechnologyServices\Student\ResetStudentPassword,
	App\Mail\InformationTechnologyServices\User\ResetUserPassword;

trait Email
{
    protected function sendTemporaryAccount($priorityNumber, $name, $password, $email){
		
		$mailData = [
			'id'       => $priorityNumber,
			'name'     => $name,
			'password' => $password
		];

		Mail::to($email)->send(new TemporaryAccount($mailData));
	}

	protected function sendApplicantStatus($name, $status, $email){
		
		$mailData = [
			'name'   => $name,
			'status' => $status
		];

		Mail::to($email)->send(new ApplicantStatus($mailData));
	}

	protected function sendResetStudentPassword($studentNumber, $name, $password, $email){
		
		$mailData = [
			'id'       => $studentNumber,
			'name'     => $name,
			'password' => $password
		];

		Mail::to($email)->send(new ResetStudentPassword($mailData));
	}

	protected function sendResetUserPassword($employeeNumber, $name, $password, $email){
		
		$mailData = [
			'id'       => $employeeNumber,
			'name'     => $name,
			'password' => $password
		];

		Mail::to($email)->send(new ResetUserPassword($mailData));
	}
}