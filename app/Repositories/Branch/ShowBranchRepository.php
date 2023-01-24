<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch;

class ShowBranchRepository extends BaseRepository
{
    public function execute($branchCode) {

        // *** Show only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            $branch = Branch::where('code', '=', $branchCode)->firstOrFail();

        } else {

            return $this->error("You're not authorized to view this branch");

        }
        
        return $this->success("Branch Found", $this->getShowData($branch));
    }
}