<?php

namespace App\Repositories\Program;

use App\Repositories\BaseRepository;

use App\Models\Program\Program;

class ShowProgramRepository extends BaseRepository
{
    public function execute($branchCode, $programCode) {

        $program = Program::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($programCode))->firstOrFail();

        // *** Show only if user and program branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $program->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            return $this->success("Program Found", 
                $this->getShowData(
                    $program, 
                    getForeign: [
                        'employee'   => ['employee_number', 'last_name', 'first_name', 'middle_name'],
                        'department' => ['code', 'name'],
                        'branch'     => ['code','name']
                    ]
                )
            );

        } else {

            return $this->error("You're not authorized to view this program");
        }
    }
}