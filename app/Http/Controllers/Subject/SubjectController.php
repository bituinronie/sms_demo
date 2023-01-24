<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Subject\IndexSubjectRequest,
    App\Http\Requests\Subject\CreateSubjectRequest,
    App\Http\Requests\Subject\ShowSubjectRequest,
    App\Http\Requests\Subject\UpdateSubjectRequest,
    App\Http\Requests\Subject\ListSubjectRequest,
    App\Http\Requests\Subject\ArchiveSubjectRequest,
    App\Http\Requests\Subject\RestoreSubjectRequest,
    App\Http\Requests\Subject\DeleteSubjectRequest;


// * REPOSITORIES
use App\Repositories\Subject\IndexSubjectRepository,
    App\Repositories\Subject\CreateSubjectRepository,
    App\Repositories\Subject\ShowSubjectRepository,
    App\Repositories\Subject\UpdateSubjectRepository,
    App\Repositories\Subject\ListSubjectRepository,
    App\Repositories\Subject\ArchiveSubjectRepository,
    App\Repositories\Subject\RestoreSubjectRepository,
    App\Repositories\Subject\DeleteSubjectRepository;

class SubjectController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $delete;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexSubjectRepository   $index,
        CreateSubjectRepository  $create,
        ShowSubjectRepository    $show,
        UpdateSubjectRepository  $update,
        ListSubjectRepository    $list,
        ArchiveSubjectRepository $archive,
        RestoreSubjectRepository $restore,
        DeleteSubjectRepository  $delete
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

    protected function index(IndexSubjectRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateSubjectRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowSubjectRequest $request, $branchCode, $subjectCode) {
        return $this->show->execute($branchCode, $subjectCode);
    }

    
    protected function update(UpdateSubjectRequest $request, $branchCode, $subjectCode) {
        return $this->update->execute($request, $branchCode, $subjectCode);
    }

    
    protected function list(ListSubjectRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveSubjectRequest $request, $branchCode, $subjectCode){
        return $this->archive->execute($branchCode, $subjectCode);
    }
    
    
    protected function restore(RestoreSubjectRequest $request, $branchCode, $subjectCode){
        return $this->restore->execute($branchCode, $subjectCode);
    }

    
    protected function delete(DeleteSubjectRequest $request, $branchCode, $subjectCode) {
        return $this->delete->execute($branchCode, $subjectCode);
    }
}
