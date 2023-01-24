<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Schedule\IndexScheduleRequest,
    App\Http\Requests\Schedule\CreateScheduleRequest,
    App\Http\Requests\Schedule\ShowScheduleRequest,
    App\Http\Requests\Schedule\UpdateScheduleRequest,
    App\Http\Requests\Schedule\ListScheduleRequest,
    App\Http\Requests\Schedule\ArchiveScheduleRequest,
    App\Http\Requests\Schedule\RestoreScheduleRequest,
    App\Http\Requests\Schedule\DeleteScheduleRequest,
    App\Http\Requests\Schedule\Miscellaneous\ScheduleValidationScheduleRequest;


// * REPOSITORIES
use App\Repositories\Schedule\IndexScheduleRepository,
    App\Repositories\Schedule\CreateScheduleRepository,
    App\Repositories\Schedule\ShowScheduleRepository,
    App\Repositories\Schedule\UpdateScheduleRepository,
    App\Repositories\Schedule\ListScheduleRepository,
    App\Repositories\Schedule\ArchiveScheduleRepository,
    App\Repositories\Schedule\RestoreScheduleRepository,
    App\Repositories\Schedule\DeleteScheduleRepository,
    App\Repositories\Schedule\Miscellaneous\ScheduleValidationScheduleRepository;

class ScheduleController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete, $scheduleValidation;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexScheduleRepository              $index,
        CreateScheduleRepository             $create,
        ShowScheduleRepository               $show,
        UpdateScheduleRepository             $update,
        ListScheduleRepository               $list,
        ArchiveScheduleRepository            $archive,
        RestoreScheduleRepository            $restore,
        DeleteScheduleRepository             $delete,
        ScheduleValidationScheduleRepository $scheduleValidation
    ){
        $this->index              = $index;
        $this->create             = $create;
        $this->show               = $show;
        $this->update             = $update;
        $this->list               = $list;
        $this->archive            = $archive;
        $this->restore            = $restore;
        $this->delete             = $delete;
        $this->scheduleValidation = $scheduleValidation;
    }

    protected function index(IndexScheduleRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateScheduleRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowScheduleRequest $request, $branchCode, $scheduleCode) {
        return $this->show->execute($branchCode, $scheduleCode);
    }

    
    protected function update(UpdateScheduleRequest $request, $branchCode, $scheduleCode) {
        return $this->update->execute($request, $branchCode, $scheduleCode);
    }

    
    protected function list(ListScheduleRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveScheduleRequest $request, $branchCode, $scheduleCode){
        return $this->archive->execute($branchCode, $scheduleCode);
    }
    
    
    protected function restore(RestoreScheduleRequest $request, $branchCode, $scheduleCode){
        return $this->restore->execute($branchCode, $scheduleCode);
    }

    
    protected function delete(DeleteScheduleRequest $request, $branchCode, $scheduleCode) {
        return $this->delete->execute($branchCode, $scheduleCode);
    }

    protected function scheduleValidation(ScheduleValidationScheduleRequest $request) {
        return $this->scheduleValidation->execute($request);
    }
}

