<?php

namespace App\Repositories\ActivityLog;

use App\Repositories\BaseRepository;

use App\Models\ActivityLog\ActivityLog;

class IndexActivityLogRepository extends BaseRepository
{
    public function execute() {

        // *** Show all data (Both User and Student)
        if (auth()->user()->hasRole(['ADMIN'])) {

            $activityLog = ActivityLog::all();

        }
        // *** Show all student data (Current Student)
        elseif(auth()->user()->hasRole(['STUDENT'])){

            $activityLog = ActivityLog::where("student_id", "=", $this->student()->id)->get();
            
        }
        // *** Show all user data (Current User)
        elseif(auth()->user()->hasRole([
            'ACCOUNTING',
            'ADMISSION',
            'AUDITOR',
            'BASIC EDUCATION',
            'CASHIER',
            'DEAN',
            'FACULTY',
            'FOREIGN',
            'HUMAN RESOURCE',
            'INFORMATION TECHNOLOGY SERVICE',
            'PROGRAM HEAD',
            'REGISTRAR',
            'SECRETARY',
            'SCHOLARSHIP'
        ])){

            $activityLog = ActivityLog::where("user_id", "=", $this->user()->id)->get();
            
        }
        else {

            return $this->error("You're not authorized to view activity logs");
            
        }

        return $this->success("Activity Logs", $this->indexActivityLog($activityLog));
    }



    //*********************************************** CUSTOM FUNCTION ***********************************************//

	private function indexActivityLog($activityLog){
        
		foreach($activityLog as $key => $value){
			$data[$key] = [
                "module"  => $value->module,
                "message" => $value->message,
                "action"  => $value->action,
                "causeBy" => [
                                "ACCOUNT NUMBER" => $value->student_id ? $value->student->student_number : $value->user->employee->employee_number,
                                "FULL NAME"      => $value->student_id ? 
                                "{$value->student->personal->last_name}, {$value->student->personal->first_name}".($value->student->personal->middle_name ? ' '.$value->student->personal->middle_name:'') :
                                "{$value->user->employee->last_name}, {$value->user->employee->first_name}".($value->user->employee->middle_name ? ' '.$value->user->employee->middle_name:'')
                            ],
                "causeTo"   => $value->causeTo,
                "data"      => $value->data,
                "createdAt" => "{$value->created_at}",
			];
		}

		return $data ?? [];
	}
}