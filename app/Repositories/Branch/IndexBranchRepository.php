<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch;

class IndexBranchRepository extends BaseRepository
{
    public function execute() {
        $branch = Branch::all();
        
        return $this->success("List of All Branch",  $this->getIndexData($branch));
    }
}