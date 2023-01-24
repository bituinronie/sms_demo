<?php

namespace App\Repositories\Strand;

use App\Repositories\BaseRepository;

use App\Models\Strand\Strand,
    App\Models\ActivityLog\ActivityLog;

class CreateStrandRepository extends BaseRepository
{
    public function execute($request){

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $strand = Strand::create([
                "code"      => strtoupper($request->code),
                "name"      => strtoupper($request->name),
                "track"     => strtoupper($request->track),
                "branch_id" => $this->getBranchId($request->branch)
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "BASIC EDUCATION",
                "message" => "CREATED A STRAND",
                "data"    => 
                [
                    "new" => [
                        "CODE"   => $strand->code,
                        "NAME"   => $strand->name,
                        "TRACK"  => $strand->track,
                        "BRANCH" => $strand->branch->name
                    ]
                ]
            ]);

        } else {

            return $this->error("You're not authorized to create a strand");
        }
    
        return $this->success("Strand Successfuly Created",
            $this->getShowData(
                $strand, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
    }
}