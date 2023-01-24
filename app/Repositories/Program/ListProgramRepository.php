<?php

namespace App\Repositories\Program;

use App\Repositories\BaseRepository;

use App\Models\Program\Program;

class ListProgramRepository extends BaseRepository
{
    public function execute(){

		// *** List all data (including another branch)
		if ($this->user()->employee->branch->type == "MAIN") {

			$program = Program::onlyTrashed()->get();
			
		}
		// *** List current branch data (current branch only)
		elseif($this->user()->employee->branch->type == "SUB"){
			
			$program = Program::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
			
		} else {

			return $this->error("You're not authorized to view all archive program");
			
		}

		return $this->success("List of All Archive Program", $this->getIndexData(
            $program, 
            getForeign: [
                'employee'   => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                'department' => ['code', 'name'],
                'branch'     => ['code', 'name']
            ],
            only: [
                'code',
                'name',
                'type',
                'duration'
            ])
        );
	}
}