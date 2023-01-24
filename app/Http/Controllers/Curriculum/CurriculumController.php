<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Curriculum\IndexCurriculumRequest,
    App\Http\Requests\Curriculum\CreateCurriculumRequest,
    App\Http\Requests\Curriculum\ShowCurriculumRequest,
    App\Http\Requests\Curriculum\UpdateCurriculumRequest,
    App\Http\Requests\Curriculum\ListCurriculumRequest,
    App\Http\Requests\Curriculum\ArchiveCurriculumRequest,
    App\Http\Requests\Curriculum\RestoreCurriculumRequest,
    App\Http\Requests\Curriculum\Miscellaneous\CodeValidationCurriculumRequest;


// * REPOSITORIES
use App\Repositories\Curriculum\IndexCurriculumRepository,
    App\Repositories\Curriculum\CreateCurriculumRepository,
    App\Repositories\Curriculum\ShowCurriculumRepository,
    App\Repositories\Curriculum\UpdateCurriculumRepository,
    App\Repositories\Curriculum\ListCurriculumRepository,
    App\Repositories\Curriculum\ArchiveCurriculumRepository,
    App\Repositories\Curriculum\RestoreCurriculumRepository,
    App\Repositories\Curriculum\Miscellaneous\CodeUpdateCurriculumRepository,
    App\Repositories\Curriculum\Miscellaneous\CodeValidationCurriculumRepository;

class CurriculumController extends Controller
{
    protected $index, $create, $show, $update, $list, $archive, $restore, $codeUpdate, $codeValidation;

    // * CONSTRUCTOR INJECTION
    public function __construct(
        IndexCurriculumRepository          $index,
        CreateCurriculumRepository         $create,
        ShowCurriculumRepository           $show,
        UpdateCurriculumRepository         $update,
        ListCurriculumRepository           $list,
        ArchiveCurriculumRepository        $archive,
        RestoreCurriculumRepository        $restore,
        CodeUpdateCurriculumRepository     $codeUpdate,
        CodeValidationCurriculumRepository $codeValidation
    ){
        $this->index          = $index;
        $this->create         = $create;
        $this->show           = $show;
        $this->update         = $update;
        $this->list           = $list;
        $this->archive        = $archive;
        $this->restore        = $restore;
        $this->codeUpdate     = $codeUpdate;
        $this->codeValidation = $codeValidation;
    }

   
    protected function index(IndexCurriculumRequest $request) {
        return $this->index->execute();
    }

    
    protected function create(CreateCurriculumRequest $request) {
        return $this->create->execute($request);
    }

    
    protected function show(ShowCurriculumRequest $request, $branchCode, $curriculumCode) {
        return $this->show->execute($branchCode, $curriculumCode);
    }

    
    protected function update(UpdateCurriculumRequest $request, $branchCode, $curriculumCode) {
        return $this->update->execute($request, $branchCode, $curriculumCode);
    }

    
    protected function list(ListCurriculumRequest $request){
        return $this->list->execute();
    }
    
    
    protected function archive(ArchiveCurriculumRequest $request, $branchCode, $curriculumCode){
        return $this->archive->execute($branchCode, $curriculumCode);
    }
    
    
    protected function restore(RestoreCurriculumRequest $request, $branchCode, $curriculumCode){
        return $this->restore->execute($branchCode, $curriculumCode);
    }


    protected function codeUpdate(UpdateCurriculumRequest $request, $branchCode, $curriculumCode) {
        return $this->codeUpdate->execute($request, $branchCode, $curriculumCode);
    }


    protected function codeValidation(CodeValidationCurriculumRequest $request) {
        return $this->codeValidation->execute();
    }
}
