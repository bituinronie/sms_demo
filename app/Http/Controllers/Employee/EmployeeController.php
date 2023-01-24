<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Employee\IndexEmployeeRequest,
    App\Http\Requests\Employee\CreateEmployeeRequest,
    App\Http\Requests\Employee\ShowEmployeeRequest,
    App\Http\Requests\Employee\UpdateEmployeeRequest,
    App\Http\Requests\Employee\ListEmployeeRequest,
    App\Http\Requests\Employee\ArchiveEmployeeRequest,
    App\Http\Requests\Employee\RestoreEmployeeRequest;


// * REPOSITORIES
use App\Repositories\Employee\IndexEmployeeRepository,
    App\Repositories\Employee\CreateEmployeeRepository,
    App\Repositories\Employee\ShowEmployeeRepository,
    App\Repositories\Employee\UpdateEmployeeRepository,
    App\Repositories\Employee\ListEmployeeRepository,
    App\Repositories\Employee\ArchiveEmployeeRepository,
    App\Repositories\Employee\RestoreEmployeeRepository;
    

class EmployeeController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexEmployeeRepository   $index,
        CreateEmployeeRepository  $create,
        ShowEmployeeRepository    $show,
        UpdateEmployeeRepository  $update,
        ListEmployeeRepository    $list,
        ArchiveEmployeeRepository $archive,
        RestoreEmployeeRepository $restore,
    ){
        $this->index   = $index;
        $this->create  = $create;
        $this->show    = $show;
        $this->update  = $update;
        $this->list    = $list;
        $this->archive = $archive;
        $this->restore = $restore;
    }

   
    protected function index(IndexEmployeeRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateEmployeeRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowEmployeeRequest $request, $employeeNumber) {
        return $this->show->execute($employeeNumber);
    }
 
    
    protected function update(UpdateEmployeeRequest $request, $employeeNumber) {
        return $this->update->execute($request, $employeeNumber);
    }

    
    protected function list(ListEmployeeRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveEmployeeRequest $request, $employeeNumber){
        return $this->archive->execute($employeeNumber);
    }
    
    
    protected function restore(RestoreEmployeeRequest $request, $employeeNumber){
        return $this->restore->execute($employeeNumber);
    }
}
