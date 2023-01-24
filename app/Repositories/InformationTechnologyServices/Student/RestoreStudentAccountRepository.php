<?php

namespace App\Repositories\InformationTechnologyServices\Student;

use App\Repositories\BaseRepository;

use App\Models\Student\StudentAccount,
	App\Models\ActivityLog\ActivityLog;

class RestoreStudentAccountRepository extends BaseRepository
{
    public function execute($studentNumber){

        $studentAccount = StudentAccount::onlyTrashed()->where('student_number', '=', $studentNumber)->firstOrFail();

        // *** Archive only if user and student branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $studentAccount->personal->admission->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $studentAccount->restore();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "RESTORE",
                "module"  => "INFORMATION TECHNOLOGY SERVICE",
                "message" => "RESTORED AN STUDENT ACCOUNT",
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

        } else {

            return $this->error("You're not authorized to archive this student account");
        }

        return $this->success("Student Account Successfuly Restored", ['studentNumber'=>$studentAccount->student_number]);
	}
}