<?php

namespace App\Repositories\InformationTechnologyServices\Student;

use App\Repositories\BaseRepository;

use Hash;

use App\Models\Student\StudentAccount,
	App\Models\ActivityLog\ActivityLog;

class RegisterStudentAccountRepository extends BaseRepository
{
    public function execute($request){

		// *** Create only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$studentAccount = StudentAccount::create([
				'applicant_id'   => $this->getPersonalId($request->studentNumber),
				'student_number' => $request->studentNumber,
				'password'       => Hash::make($request->password)
			]);

			$studentAccount->assignRole('STUDENT');

			ActivityLog::create([
				"user_id" => $this->user()->id,
				"action"  => "CREATE",
				"module"  => "INFORMATION TECHNOLOGY SERVICE",
				"message" => "REGISTERED A STUDENT ACCOUNT",
				"data"    => 
				[
					"new" => [
						"STUDENT NUMBER"   => $studentAccount->student_number,
						"FULL NAME"        => "{$studentAccount->personal->last_name}, {$studentAccount->personal->first_name}".($studentAccount->personal->middle_name ? ' '.$studentAccount->personal->middle_name:''),
						"EDUCATION LEVEL"  => $studentAccount->personal->admission->education_level,
						"GRADE YEAR LEVEL" => $studentAccount->personal->admission->grade_year_level,
						"SEMESTER"         => $studentAccount->personal->admission->semester,
						"BRANCH"           => $studentAccount->personal->admission->branch->name,
						"SCHOOL YEAR"      => $studentAccount->personal->admission->school_year,
					]
				]
			]);

			return $this->success("Student Account Successfully Created", ['studentNumber' => $studentAccount->student_number]);

		} else {

			return $this->error("You're not authorized to register a student");

		}
	}
}