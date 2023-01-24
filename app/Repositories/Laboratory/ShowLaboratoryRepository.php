<?php

namespace App\Repositories\Laboratory;

use App\Repositories\BaseRepository;

use App\Models\Laboratory\Laboratory;

class ShowLaboratoryRepository extends BaseRepository
{
    public function execute($branchCode, $laboratoryCode){

        $laboratory = Laboratory::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($laboratoryCode))->firstOrFail();

        // *** Show only if user and laboratory branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $laboratory->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            return $this->success("Laboratory Found", 
                $this->getShowData(
                    $laboratory, 
                    getForeign: [
                        'branch' => ['code','name']
                    ]
                )
            );

        } else {

            return $this->error("You're not authorized to view this laboratory");

        }
    }
}