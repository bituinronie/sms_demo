<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand;

class ShowStrandRepository extends BaseRepository
{
    public function execute($branchCode, $strandCode){
            
        $strand  = Strand::where('branch_id', '=', $this->getBranchId($branchCode))
        ->where('code', '=', strtoupper($strandCode))->firstOrFail();

        // *** Show only if user and strand branch is same or if user is main branch
        if (
            $this->user()->employee->branch->id == $strand->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            return $this->success("Strand Found", 
                $this->getShowData(
                    $strand, 
                    getForeign: [
                        'branch' => ['code','name']
                    ]
                )
            );

        } else {

            return $this->error("You're not authorized to view this strand");
        }
    }
}