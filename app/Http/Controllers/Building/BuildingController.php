<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Building\IndexBuildingRequest,
    App\Http\Requests\Building\CreateBuildingRequest,
    App\Http\Requests\Building\ShowBuildingRequest,
    App\Http\Requests\Building\UpdateBuildingRequest,
    App\Http\Requests\Building\ListBuildingRequest,
    App\Http\Requests\Building\ArchiveBuildingRequest,
    App\Http\Requests\Building\RestoreBuildingRequest,
    App\Http\Requests\Building\DeleteBuildingRequest;


// * REPOSITORIES
use App\Repositories\Building\IndexBuildingRepository,
    App\Repositories\Building\CreateBuildingRepository,
    App\Repositories\Building\ShowBuildingRepository,
    App\Repositories\Building\UpdateBuildingRepository,
    App\Repositories\Building\ListBuildingRepository,
    App\Repositories\Building\ArchiveBuildingRepository,
    App\Repositories\Building\RestoreBuildingRepository,
    App\Repositories\Building\DeleteBuildingRepository;
    

class BuildingController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexBuildingRepository   $index,
        CreateBuildingRepository  $create,
        ShowBuildingRepository    $show,
        UpdateBuildingRepository  $update,
        ListBuildingRepository    $list,
        ArchiveBuildingRepository $archive,
        RestoreBuildingRepository $restore,
        DeleteBuildingRepository  $delete
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

   
    protected function index(IndexBuildingRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateBuildingRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowBuildingRequest $request, $branchCode, $buildingCode) {
        return $this->show->execute($branchCode, $buildingCode);
    }

    
    protected function update(UpdateBuildingRequest $request, $branchCode, $buildingCode) {
        return $this->update->execute($request, $branchCode, $buildingCode);
    }

    
    protected function list(ListBuildingRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveBuildingRequest $request, $branchCode, $buildingCode){
        return $this->archive->execute($branchCode, $buildingCode);
    }
    
    
    protected function restore(RestoreBuildingRequest $request, $branchCode, $buildingCode){
        return $this->restore->execute($branchCode, $buildingCode);
    }

    
    protected function delete(DeleteBuildingRequest $request, $branchCode, $buildingCode) {
        return $this->delete->execute($branchCode, $buildingCode);
    }
}
