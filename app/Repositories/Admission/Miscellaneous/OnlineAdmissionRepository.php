<?php

namespace App\Repositories\Admission\Miscellaneous;

use App\Repositories\BaseRepository;

// *** REPOSITORIES
use App\Repositories\Branch\IndexBranchRepository,
    App\Repositories\Program\Miscellaneous\IndexOnlineProgramRepository,
    App\Repositories\Strand\Miscellaneous\IndexOnlineStrandRepository;

use App\Models\Branch\Branch;

class OnlineAdmissionRepository extends BaseRepository
{

    protected $branch, $program, $strand;

    public function __construct(
        IndexBranchRepository        $branch,
        IndexOnlineProgramRepository $program,
        IndexOnlineStrandRepository  $strand,

    ){
        $this->branch  = $branch;
        $this->program = $program;
        $this->strand  = $strand;
    }

    public function execute($branchCode, $type){

        $branch = Branch::where('type', '=', 'MAIN')->firstOrFail();

        $allBranch  = $this->branch->execute();
        $allProgram = $this->program->execute($branchCode ?? $branch->code, $type ?? 'UNDERGRADUATE');
        $allStrand  = $this->strand->execute($branchCode ?? $branch->code);
        
        return $this->success("Online Enrollment", [
            "branch"  => $allBranch->original,
            "program" => $allProgram->original,
            "strand"  => $allStrand->original
        ]);
	}
}