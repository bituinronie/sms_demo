<?php

namespace App\Repositories\Branch;

use App\Repositories\BaseRepository;

use App\Models\Branch\Branch,
    App\Models\ActivityLog\ActivityLog;

class CreateBranchRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is main branch
        if ($this->user()->employee->branch->type == "MAIN"){

            $branch = Branch::create([
                "code" => $request->code,
                "name" => strtoupper($request->name),
                "type" => strtoupper($request->type)
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "SYSTEM",
                "message" => "CREATED A BRANCH",
                "data"    => ["new" => $branch]
            ]);

        } else {

            return $this->error("You're not authorized to create a branch");

        }
        

        return $this->success("Branch Successfuly Created", $this->getShowData($branch));
    }
}