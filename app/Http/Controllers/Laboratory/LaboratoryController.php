<?php

namespace App\Http\Controllers\Laboratory;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Laboratory\IndexLaboratoryRequest,
    App\Http\Requests\Laboratory\CreateLaboratoryRequest,
    App\Http\Requests\Laboratory\ShowLaboratoryRequest,
    App\Http\Requests\Laboratory\UpdateLaboratoryRequest,
    App\Http\Requests\Laboratory\ListLaboratoryRequest,
    App\Http\Requests\Laboratory\ArchiveLaboratoryRequest,
    App\Http\Requests\Laboratory\RestoreLaboratoryRequest,
    App\Http\Requests\Laboratory\DeleteLaboratoryRequest;


// * REPOSITORIES
use App\Repositories\Laboratory\IndexLaboratoryRepository,
    App\Repositories\Laboratory\CreateLaboratoryRepository,
    App\Repositories\Laboratory\ShowLaboratoryRepository,
    App\Repositories\Laboratory\UpdateLaboratoryRepository,
    App\Repositories\Laboratory\ListLaboratoryRepository,
    App\Repositories\Laboratory\ArchiveLaboratoryRepository,
    App\Repositories\Laboratory\RestoreLaboratoryRepository,
    App\Repositories\Laboratory\DeleteLaboratoryRepository;

class LaboratoryController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexLaboratoryRepository   $index,
        CreateLaboratoryRepository  $create,
        ShowLaboratoryRepository    $show,
        UpdateLaboratoryRepository  $update,
        ListLaboratoryRepository    $list,
        ArchiveLaboratoryRepository $archive,
        RestoreLaboratoryRepository $restore,
        DeleteLaboratoryRepository  $delete
    ){
        $this->index   = $index;
        $this->create  = $create;
        $this->show    = $show;
        $this->update  = $update;
        $this->list    = $list;
        $this->archive = $archive;
        $this->restore = $restore;
        $this->delete  = $delete;
    }


    protected function index(IndexLaboratoryRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateLaboratoryRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowLaboratoryRequest $request, $branchCode, $laboratoryCode) {
        return $this->show->execute($branchCode, $laboratoryCode);
    }

    
    protected function update(UpdateLaboratoryRequest $request, $branchCode, $laboratoryCode) {
        return $this->update->execute($request, $branchCode, $laboratoryCode);
    }

    
    protected function list(ListLaboratoryRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveLaboratoryRequest $request, $branchCode, $laboratoryCode){
        return $this->archive->execute($branchCode, $laboratoryCode);
    }
    
    
    protected function restore(RestoreLaboratoryRequest $request, $branchCode, $laboratoryCode){
        return $this->restore->execute($branchCode, $laboratoryCode);
    }

    
    protected function delete(DeleteLaboratoryRequest $request, $branchCode, $laboratoryCode) {
        return $this->delete->execute($branchCode, $laboratoryCode);
    }
}
