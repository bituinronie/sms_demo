<?php

namespace App\Repositories\Section;

use App\Repositories\BaseRepository;

use App\Models\Section\Section;

class ListSectionRepository extends BaseRepository
{
    public function execute() {
            
        // *** Show all data (including another branch)
        if ($this->user()->employee->branch->type == "MAIN") {

            $section = Section::onlyTrashed()->get();

        }
        // *** Show all data (current branch only)
        elseif($this->user()->employee->branch->type == "SUB"){

            $section = Section::onlyTrashed()->where("branch_id", "=", $this->user()->employee->branch->id)->get();
            
        }
        else {

            return $this->error("You're not authorized to view all section");
            
        }

        return $this->success("List of All Section",  $this->getIndexData(
            $section, 
            getForeign: [
                'branch'     => ['code', 'name'],
                'department' => ['code', 'name']
            ],
            only: [
                'code',
                'type',
                'year_level',
                'semester',
                'class_size'
            ])
        );
    }
}