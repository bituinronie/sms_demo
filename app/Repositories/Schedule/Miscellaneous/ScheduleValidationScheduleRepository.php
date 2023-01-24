<?php

namespace App\Repositories\Schedule\Miscellaneous;

use App\Repositories\BaseRepository;

use Arr, Carbon\Carbon;

use App\Models\Section\Section;

class ScheduleValidationScheduleRepository extends BaseRepository
{
    public function execute($request) {

        // *** Initialized section: Schedule and section must be same branch (used for: branch and section)
        $section = Section::where('code', '=', strtoupper($request->section))->firstOrFail();

        // *** Create only if user is same branch with the request branch or if user is main branch
        if (
            $this->user()->employee->branch->id == $section->branch->id ||
            $this->user()->employee->branch->type == "MAIN"
        ) {

            if(Arr::accessible($conflict=$this->hasConflict($section->branch->id, $request->schedule))){

                return response()->json([
                    'message' => "Conflict Found",
                    'results' => $conflict,
                    'code'    => 409,
                    'error'   => true
                ], 409);

            }
            
        } else {

            return $this->error("You're not authorized to create a schedule");
        }

        return $this->success("Schedule has no conflict", ['section' => strtoupper($request->section)]);

    }
}