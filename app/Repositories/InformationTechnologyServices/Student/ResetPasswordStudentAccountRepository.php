<?php

namespace App\Repositories\InformationTechnologyServices\Student;

use App\Repositories\BaseRepository;

use Str, Hash;

use App\Models\Student\StudentAccount,
	App\Models\ActivityLog\ActivityLog;

class ResetPasswordStudentAccountRepository extends BaseRepository
{
    public function execute($studentNumber){

		// *** Reset only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$password = Str::random(8);

			$studentAccount = StudentAccount::where('student_number', '=', $studentNumber)->firstOrFail();

			$studentAccount->update([
				'password' => Hash::make($password)
			]);

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "UPDATE",
				"module"  => "INFORMATION TECHNOLOGY SERVICE",
				"message" => "RESET AN STUDENT ACCOUNT PASSWORD",
				"causeTo" => [
					"STUDENT NUMBER"   => $studentAccount->student_number,
					"FULL NAME"        => "{$studentAccount->personal->last_name}, {$studentAccount->personal->first_name}".($studentAccount->personal->middle_name ? ' '.$studentAccount->personal->middle_name:''),
					"EDUCATION LEVEL"  => $studentAccount->personal->admission->education_level,
					"GRADE YEAR LEVEL" => $studentAccount->personal->admission->grade_year_level,
					"SEMESTER"         => $studentAccount->personal->admission->semester,
					"BRANCH"           => $studentAccount->personal->admission->branch->name,
					"SCHOOL YEAR"      => $studentAccount->personal->admission->school_year,
				]
			]);

			$this->sendResetStudentPassword(
				$studentNumber,
				$studentAccount->personal->first_name,
				$password,
				$studentAccount->personal->email_address
			);

			return $this->success("Student Account Password Successfully Reset", ['studentNumber' => $studentAccount->student_number]);

		} else {

			return $this->error("You're not authorized to reset the password of this student");

		}
	}
}