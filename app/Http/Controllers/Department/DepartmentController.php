<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Department\IndexDepartmentRequest,
    App\Http\Requests\Department\CreateDepartmentRequest,
    App\Http\Requests\Department\ShowDepartmentRequest,
    App\Http\Requests\Department\UpdateDepartmentRequest,
    App\Http\Requests\Department\ListDepartmentRequest,
    App\Http\Requests\Department\ArchiveDepartmentRequest,
    App\Http\Requests\Department\RestoreDepartmentRequest,
    App\Http\Requests\Department\DeleteDepartmentRequest;


// * REPOSITORIES
use App\Repositories\Department\IndexDepartmentRepository,
    App\Repositories\Department\CreateDepartmentRepository,
    App\Repositories\Department\ShowDepartmentRepository,
    App\Repositories\Department\UpdateDepartmentRepository,
    App\Repositories\Department\ListDepartmentRepository,
    App\Repositories\Department\ArchiveDepartmentRepository,
    App\Repositories\Department\RestoreDepartmentRepository,
    App\Repositories\Department\DeleteDepartmentRepository;


class DepartmentController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexDepartmentRepository   $index,
        CreateDepartmentRepository  $create,
        ShowDepartmentRepository    $show,
        UpdateDepartmentRepository  $update,
        ListDepartmentRepository    $list,
        ArchiveDepartmentRepository $archive,
        RestoreDepartmentRepository $restore,
        DeleteDepartmentRepository  $delete
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

   
    protected function index(IndexDepartmentRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateDepartmentRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowDepartmentRequest $request, $branchCode, $departmentCode) {
        return $this->show->execute($branchCode, $departmentCode);
    }
 
    
    protected function update(UpdateDepartmentRequest $request, $branchCode, $departmentCode) {
        return $this->update->execute($request, $branchCode, $departmentCode);
    }

    
    protected function list(ListDepartmentRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveDepartmentRequest $request, $branchCode, $departmentCode){
        return $this->archive->execute($branchCode, $departmentCode);
    }
    
    
    protected function restore(RestoreDepartmentRequest $request, $branchCode, $departmentCode){
        return $this->restore->execute($branchCode, $departmentCode);
    }


    protected function delete(DeleteDepartmentRequest $request, $branchCode, $departmentCode) {
        return $this->delete->execute($branchCode, $departmentCode);
    }
}
