<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Section\IndexSectionRequest,
    App\Http\Requests\Section\CreateSectionRequest,
    App\Http\Requests\Section\ShowSectionRequest,
    App\Http\Requests\Section\UpdateSectionRequest,
    App\Http\Requests\Section\ListSectionRequest,
    App\Http\Requests\Section\ArchiveSectionRequest,
    App\Http\Requests\Section\RestoreSectionRequest,
    App\Http\Requests\Section\DeleteSectionRequest,
    App\Http\Requests\Section\Miscellaneous\SectionScheduleSectionRequest;


// * REPOSITORIES
use App\Repositories\Section\IndexSectionRepository,
    App\Repositories\Section\CreateSectionRepository,
    App\Repositories\Section\ShowSectionRepository,
    App\Repositories\Section\UpdateSectionRepository,
    App\Repositories\Section\ListSectionRepository,
    App\Repositories\Section\ArchiveSectionRepository,
    App\Repositories\Section\RestoreSectionRepository,
    App\Repositories\Section\DeleteSectionRepository,
    App\Repositories\Section\Miscellaneous\SectionScheduleSectionRepository;

class SectionController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete, $sectionSchedule;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexSectionRepository           $index,
        CreateSectionRepository          $create,
        ShowSectionRepository            $show,
        UpdateSectionRepository          $update,
        ListSectionRepository            $list,
        ArchiveSectionRepository         $archive,
        RestoreSectionRepository         $restore,
        DeleteSectionRepository          $delete,
        SectionScheduleSectionRepository $sectionSchedule
    ){
        $this->index           = $index;
        $this->create          = $create;
        $this->show            = $show;
        $this->update          = $update;
        $this->list            = $list;
        $this->archive         = $archive;
        $this->restore         = $restore;
        $this->delete          = $delete;
        $this->sectionSchedule = $sectionSchedule;
    }

    protected function index(IndexSectionRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateSectionRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowSectionRequest $request, $branchCode, $sectionCode) {
        return $this->show->execute($branchCode, $sectionCode);
    }

    
    protected function update(UpdateSectionRequest $request, $branchCode, $sectionCode) {
        return $this->update->execute($request, $branchCode, $sectionCode);
    }

    
    protected function list(ListSectionRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveSectionRequest $request, $branchCode, $sectionCode){
        return $this->archive->execute($branchCode, $sectionCode);
    }
    
    
    protected function restore(RestoreSectionRequest $request, $branchCode, $sectionCode){
        return $this->restore->execute($branchCode, $sectionCode);
    }

    
    protected function delete(DeleteSectionRequest $request, $branchCode, $sectionCode) {
        return $this->delete->execute($branchCode, $sectionCode);
    }


    protected function sectionSchedule(SectionScheduleSectionRequest $request, $branchCode, $sectionCode) {
        return $this->sectionSchedule->execute($branchCode, $sectionCode);
    }
}
