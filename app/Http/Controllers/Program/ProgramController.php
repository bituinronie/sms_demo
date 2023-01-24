<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Program\IndexProgramRequest,
    App\Http\Requests\Program\CreateProgramRequest,
    App\Http\Requests\Program\ShowProgramRequest,
    App\Http\Requests\Program\UpdateProgramRequest,
    App\Http\Requests\Program\ListProgramRequest,
    App\Http\Requests\Program\ArchiveProgramRequest,
    App\Http\Requests\Program\RestoreProgramRequest,
    App\Http\Requests\Program\DeleteProgramRequest;


// * REPOSITORIES
use App\Repositories\Program\IndexProgramRepository,
    App\Repositories\Program\CreateProgramRepository,
    App\Repositories\Program\ShowProgramRepository,
    App\Repositories\Program\UpdateProgramRepository,
    App\Repositories\Program\ListProgramRepository,
    App\Repositories\Program\ArchiveProgramRepository,
    App\Repositories\Program\RestoreProgramRepository,
    App\Repositories\Program\DeleteProgramRepository;

class ProgramController extends Controller
{

    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexProgramRepository   $index,
        CreateProgramRepository  $create,
        ShowProgramRepository    $show,
        UpdateProgramRepository  $update,
        ListProgramRepository    $list,
        ArchiveProgramRepository $archive,
        RestoreProgramRepository $restore,
        DeleteProgramRepository  $delete,
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

   
    protected function index(IndexProgramRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateProgramRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowProgramRequest $request, $branchCode, $programCode) {
        return $this->show->execute($branchCode, $programCode);
    }
 
    
    protected function update(UpdateProgramRequest $request, $branchCode, $programCode) {
        return $this->update->execute($request, $branchCode, $programCode);
    }

    
    protected function list(ListProgramRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveProgramRequest $request, $branchCode, $programCode){
        return $this->archive->execute($branchCode, $programCode);
    }
    
    
    protected function restore(RestoreProgramRequest $request, $branchCode, $programCode){
        return $this->restore->execute($branchCode, $programCode);
    }


    protected function delete(DeleteProgramRequest $request, $branchCode, $programCode) {
        return $this->delete->execute($branchCode, $programCode);
    }
}
