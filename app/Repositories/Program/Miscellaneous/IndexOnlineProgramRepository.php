<?php

namespace App\Repositories\Program\Miscellaneous;

use App\Repositories\BaseRepository;

use App\Models\Program\Program;

class IndexOnlineProgramRepository extends BaseRepository
{
    public function execute($branchCode, $type) {
        $program = [];
        
        // *** Show undergraduate data (current branch only)
        if(strtoupper($type) == "UNDERGRADUATE"){

            $program = Program::where("branch_id", "=", $this->getBranchId($branchCode))
            ->where('type', '=', 'UNDERGRADUATE')->get();
            
        }
        // *** Show postgraduate data (current branch only) 
        elseif(strtoupper($type) == "POSTGRADUATE"){

            $program = Program::where("branch_id", "=", $this->getBranchId($branchCode))
            ->where('type', '=', 'POSTGRADUATE')->get();
            
        }

        return $this->success("List of All Program", $this->getIndexData($program, getForeign: ['branch'=>['code', 'name']]));
    }
}