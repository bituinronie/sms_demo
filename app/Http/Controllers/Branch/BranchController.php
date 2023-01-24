<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Branch\IndexBranchRequest,
    App\Http\Requests\Branch\CreateBranchRequest,
    App\Http\Requests\Branch\ShowBranchRequest,
    App\Http\Requests\Branch\UpdateBranchRequest,
    App\Http\Requests\Branch\ListBranchRequest,
    App\Http\Requests\Branch\ArchiveBranchRequest,
    App\Http\Requests\Branch\RestoreBranchRequest,
    App\Http\Requests\Branch\DeleteBranchRequest;


// * REPOSITORIES
use App\Repositories\Branch\IndexBranchRepository,
    App\Repositories\Branch\CreateBranchRepository,
    App\Repositories\Branch\ShowBranchRepository,
    App\Repositories\Branch\UpdateBranchRepository,
    App\Repositories\Branch\ListBranchRepository,
    App\Repositories\Branch\ArchiveBranchRepository,
    App\Repositories\Branch\RestoreBranchRepository,
    App\Repositories\Branch\DeleteBranchRepository;

class BranchController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexBranchRepository   $index,
        CreateBranchRepository  $create,
        ShowBranchRepository    $show,
        UpdateBranchRepository  $update,
        ListBranchRepository    $list,
        ArchiveBranchRepository $archive,
        RestoreBranchRepository $restore,
        DeleteBranchRepository  $delete
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

   
    protected function index(IndexBranchRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateBranchRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowBranchRequest $request, $branchCode) {
        return $this->show->execute($branchCode);
    }
 
    
    protected function update(UpdateBranchRequest $request, $branchCode) {
        return $this->update->execute($request, $branchCode);
    }

    
    protected function list(ListBranchRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveBranchRequest $request, $branchCode){
        return $this->archive->execute($branchCode);
    }
    
    
    protected function restore(RestoreBranchRequest $request, $branchCode){
        return $this->restore->execute($branchCode);
    }


    protected function delete(DeleteBranchRequest $request, $branchCode) {
        return $this->delete->execute($branchCode);
    }
}
