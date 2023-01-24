<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;

use App\Models\Subject\Subject;

class IndexSubjectRepository extends BaseRepository
{
    public function execute() { 
            
        // *** Show all data (including another branch)
        if ($this->user()->employee->branch->type == "MAIN") {

            $subject = Subject::all();

        }
        // *** Show all data (current branch only)
        elseif($this->user()->employee->branch->type == "SUB"){

            $subject = Subject::where("branch_id", "=", $this->user()->employee->branch->id)->get();
            
        }
        else {

            return $this->error("You're not authorized to view all subject");
        }

        return $this->success("List of All Subject", $this->getIndexData(
            $subject, 
            getForeign: [
                'branch'     => ['code','name'],
                'laboratory' => ['code','name'],
                'department' => ['code','name'],
            ])
        );
    }
}