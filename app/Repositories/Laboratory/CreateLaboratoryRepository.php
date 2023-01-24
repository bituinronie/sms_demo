<?php

namespace App\Repositories\Laboratory;

use App\Repositories\BaseRepository;

use App\Models\Laboratory\Laboratory,
    App\Models\ActivityLog\ActivityLog;

class CreateLaboratoryRepository extends BaseRepository
{
    public function execute($request) {

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $this->getBranchId($request->branch) ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            $laboratory = Laboratory::create([
                "code"      => strtoupper($request->code),
                "name"      => strtoupper($request->name),
                "amount"    => $request->amount ?? 0,
                "branch_id" => $this->getBranchId($request->branch)
            ]);

            ActivityLog::create([
                "user_id" => $this->user()->id,
                "action"  => "CREATE",
                "module"  => "FACILITY",
                "message" => "CREATED A LABORATORY",
                "data"    => 
                [
                    "new" => [
                        "CODE"   => $laboratory->code,
                        "NAME"   => $laboratory->name,
                        "AMOUNT" => $laboratory->amount,
                        "BRANCH" => $laboratory->branch->name
                    ]
                ]
            ]);

        } else {

            return $this->error("You're not authorized to create a laboratory");

        }

        return $this->success("Laboratory Successfuly Created",
            $this->getShowData(
                $laboratory, 
                getForeign: [
                    'branch' => ['code','name']
                ]
            )
        );
    }
}