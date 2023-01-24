<?php

namespace App\Repositories\InformationTechnologyServices\User;

use App\Repositories\BaseRepository;

use App\Models\User\UserAccount,
	App\Models\ActivityLog\ActivityLog;

class ArchiveUserAccountRepository extends BaseRepository
{
    public function execute($employeeNumber){

        $userAccount = UserAccount::where('employee_number', '=', $employeeNumber)->firstOrFail();

        // *** Archive only if user and student branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $userAccount->employee->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $userAccount->delete();

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "ARCHIVE",
                "module"  => "INFORMATION TECHNOLOGY SERVICE",
                "message" => "ARCHIVED AN USER ACCOUNT",
                "causeTo" => [
					"EMPLOYEE NUMBER" => $userAccount->employee->employee_number,
					"FULL NAME"       => "{$userAccount->employee->last_name}, {$userAccount->employee->first_name}".($userAccount->employee->middle_name ? ' '.$userAccount->employee->middle_name:''),
					"TYPE"            => $userAccount->employee->type,
					"DEPARTMENT"      => $userAccount->employee->department->name,
					"BRANCH"          => $userAccount->employee->branch->name
				]
            ]);

        } else {

            return $this->error("You're not authorized to archive this user account");
        }

        return $this->success("User Account Successfuly Archived", ['employeeNumber'=>$userAccount->employee_number]);
	}
}