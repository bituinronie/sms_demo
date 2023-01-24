<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand;

class IndexStrandRepository extends BaseRepository
{
    public function execute() {

        // *** Show all data (including another branch)
        if ($this->user()->employee->branch->type == "MAIN") {

            $strand = Strand::all();
            
        }
        // *** Show all current branch data (current branch only) 
        elseif($this->user()->employee->branch->type == "SUB"){

            $strand = Strand::where("branch_id", "=", $this->user()->employee->branch->id)->get();
            
        } else {

            return $this->error("You're not authorized to view all strand");
        }

        return $this->success("List of All Strand", $this->getIndexData($strand, getForeign: ['branch'=>['code', 'name']]));
    }
}