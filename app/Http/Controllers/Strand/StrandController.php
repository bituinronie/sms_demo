<?php

namespace App\Http\Controllers\Strand;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Strand\IndexStrandRequest,
    App\Http\Requests\Strand\CreateStrandRequest,
    App\Http\Requests\Strand\ShowStrandRequest,
    App\Http\Requests\Strand\UpdateStrandRequest,
    App\Http\Requests\Strand\ListStrandRequest,
    App\Http\Requests\Strand\ArchiveStrandRequest,
    App\Http\Requests\Strand\RestoreStrandRequest,
    App\Http\Requests\Strand\DeleteStrandRequest;


// * REPOSITORIES
use App\Repositories\Strand\IndexStrandRepository,
    App\Repositories\Strand\CreateStrandRepository,
    App\Repositories\Strand\ShowStrandRepository,
    App\Repositories\Strand\UpdateStrandRepository,
    App\Repositories\Strand\ListStrandRepository,
    App\Repositories\Strand\ArchiveStrandRepository,
    App\Repositories\Strand\RestoreStrandRepository,
    App\Repositories\Strand\DeleteStrandRepository;

class StrandController extends Controller
{

    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexStrandRepository   $index,
        CreateStrandRepository  $create,
        ShowStrandRepository    $show,
        UpdateStrandRepository  $update,
        ListStrandRepository    $list,
        ArchiveStrandRepository $archive,
        RestoreStrandRepository $restore,
        DeleteStrandRepository  $delete,
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

   
    protected function index(IndexStrandRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateStrandRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowStrandRequest $request, $branchCode, $strandCode) {
        return $this->show->execute($branchCode, $strandCode);
    }

    
    protected function update(UpdateStrandRequest $request, $branchCode, $strandCode) {
        return $this->update->execute($request, $branchCode, $strandCode);
    }


    protected function list(ListStrandRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveStrandRequest $request, $branchCode, $strandCode){
        return $this->archive->execute($branchCode, $strandCode);
    }
    
    
    protected function restore(RestoreStrandRequest $request, $branchCode, $strandCode){
        return $this->restore->execute($branchCode, $strandCode);
    }

    
    protected function delete(DeleteStrandRequest $request, $branchCode, $strandCode) {
        return $this->delete->execute($branchCode, $strandCode);
    }
}
