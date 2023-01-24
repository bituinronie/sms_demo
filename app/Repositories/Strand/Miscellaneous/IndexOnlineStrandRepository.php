<?php

namespace App\Repositories\Strand\Miscellaneous;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand;

class IndexOnlineStrandRepository extends BaseRepository
{
    public function execute($branchCode) {

        // *** Show all data (current branch only)
        $strand = Strand::where("branch_id", "=", $this->getBranchId($branchCode))->get();

        return $this->success("List of All Strand", $this->getIndexData($strand, getForeign: ['branch'=>['code', 'name']]));
    }
}