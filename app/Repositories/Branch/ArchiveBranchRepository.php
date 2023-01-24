<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch,
	App\Models\Admission\ApplicantAdmission,
	App\Models\Building\Building,
	App\Models\Department\Department,
	App\Models\Employee\Employee,
	App\Models\Laboratory\Laboratory,
	App\Models\Program\Program,
	App\Models\Room\Room,
	App\Models\Strand\Strand,
	App\Models\Subject\Subject,
	App\Models\ActivityLog\ActivityLog;

class ArchiveBranchRepository extends BaseRepository
{
    public function execute($branchCode){

		// *** Archive only if user is main branch
		if ($this->user()->employee->branch->type == "MAIN"){

			$branch     = Branch::where('code', '=', $branchCode)->firstOrFail();

			// *** Don't archive if used by other module
			$admission  = ApplicantAdmission::where('branch_id', '=', $branch->id)->get();
			$building   = Building::where('branch_id', '=', $branch->id)->get();
			$department = Department::where('branch_id', '=', $branch->id)->get();
			$employee   = Employee::where('branch_id', '=', $branch->id)->get();
			$laboratory = Laboratory::where('branch_id', '=', $branch->id)->get();
			$program    = Program::where('branch_id', '=', $branch->id)->get();
			$room       = Room::where('branch_id', '=', $branch->id)->get();
			$strand     = Strand::where('branch_id', '=', $branch->id)->get();
			$subject    = Subject::where('branch_id', '=', $branch->id)->get();

			if (
				$admission->isEmpty()  ||
				$building->isEmpty()   ||
				$department->isEmpty() ||
				$employee->isEmpty()   ||
				$laboratory->isEmpty() ||
				$program->isEmpty()    ||
				$room->isEmpty()       ||
				$strand->isEmpty()	   ||
				$subject->isEmpty()
			) {

				$branch->delete();

				ActivityLog::create([
					"user_id" => $this->user()->id,
					"action"  => "ARCHIVE",
					"module"  => "SYSTEM",
					"message" => "ARCHIVED A BRANCH",
					"causeTo" => $this->activityCauseTo($branch, only: ['code', 'name'])
				]);

			} elseif ($admission->isNotEmpty()) {

				return $this->error("Can't archive because this branch is currently in use");
			}

		} else {

			return $this->error("You're not authorized to archive this branch");

		}

		return $this->success("Branch Successfuly Archived", $this->getShowData($branch));
	}
}