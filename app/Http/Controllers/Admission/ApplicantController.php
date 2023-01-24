<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;

// * REQUEST
use App\Http\Requests\Admission\IndexAdmissionRequest,
    App\Http\Requests\Admission\CreateAdmissionRequest,
    App\Http\Requests\Admission\ShowAdmissionRequest,
    App\Http\Requests\Admission\UpdateAdmissionRequest,
    App\Http\Requests\Admission\ListAdmissionRequest,
    App\Http\Requests\Admission\ArchiveAdmissionRequest,
    App\Http\Requests\Admission\RestoreAdmissionRequest,
    App\Http\Requests\Admission\DeleteAdmissionRequest,
    App\Http\Requests\Admission\Miscellaneous\StatusAdmissionRequest,
    App\Http\Requests\Admission\Miscellaneous\EmailUpdateAdmissionRequest,
    App\Http\Requests\Admission\Miscellaneous\EmailValidationAdmissionRequest,
    App\Http\Requests\Admission\Miscellaneous\FeederSchoolAdmissionRequest;


// * REPOSITORIES
use App\Repositories\Admission\IndexAdmissionRepository,
    App\Repositories\Admission\CreateAdmissionRepository,
    App\Repositories\Admission\ShowAdmissionRepository,
    App\Repositories\Admission\UpdateAdmissionRepository,
    App\Repositories\Admission\ListAdmissionRepository,
    App\Repositories\Admission\ArchiveAdmissionRepository,
    App\Repositories\Admission\RestoreAdmissionRepository,
    App\Repositories\Admission\DeleteAdmissionRepository,
    App\Repositories\Admission\Miscellaneous\StatusAdmissionRepository,
    App\Repositories\Admission\Miscellaneous\EmailUpdateAdmissionRepository,
    App\Repositories\Admission\Miscellaneous\EmailValidationAdmissionRepository,
    App\Repositories\Admission\Miscellaneous\FeederSchoolAdmissionRepository;


class ApplicantController extends Controller
{
  protected $index, $create, $show, $update, $list, $archive, $restore, $delete, 
            $statusUpdate, $emailUpdate, $emailValidation, $feederSchool;

  // * CONSTRUCTOR INJECTION
  public function __construct(
    IndexAdmissionRepository           $index,
    CreateAdmissionRepository          $create,
    ShowAdmissionRepository            $show,
    UpdateAdmissionRepository          $update,
    ListAdmissionRepository            $list,
    ArchiveAdmissionRepository         $archive,
    RestoreAdmissionRepository         $restore,
    DeleteAdmissionRepository          $delete,
    StatusAdmissionRepository          $statusUpdate,
    EmailUpdateAdmissionRepository     $emailUpdate,
    EmailValidationAdmissionRepository $emailValidation,
    FeederSchoolAdmissionRepository    $feederSchool
  ){
    $this->index           = $index;
    $this->create          = $create;
    $this->show            = $show;
    $this->update          = $update;
    $this->list            = $list;
    $this->archive         = $archive;
    $this->restore         = $restore;
    $this->delete          = $delete;
    $this->statusUpdate    = $statusUpdate;
    $this->emailUpdate     = $emailUpdate;
    $this->emailValidation = $emailValidation;
    $this->feederSchool    = $feederSchool;
  }


  protected function index(IndexAdmissionRequest $request){
    return $this->index->execute();
  }


  protected function create(CreateAdmissionRequest $request){
    return $this->create->execute($request);
  }


  protected function show(ShowAdmissionRequest $request, $priorityNumber){
    return $this->show->execute($priorityNumber);
  }


  protected function update(UpdateAdmissionRequest $request, $priorityNumber){
    return $this->update->execute($request, $priorityNumber);
  }


  protected function list(ListAdmissionRequest $request){
    return $this->list->execute();
  }


  protected function archive(ArchiveAdmissionRequest $request, $priorityNumber){
    return $this->archive->execute($priorityNumber);
  }


  protected function restore(RestoreAdmissionRequest $request, $priorityNumber){
    return $this->restore->execute($priorityNumber);
  }


  protected function delete(DeleteAdmissionRequest $request, $priorityNumber){
    return $this->delete->execute($priorityNumber);
  }


  protected function statusUpdate(StatusAdmissionRequest $request, $priorityNumber){
    return $this->statusUpdate->execute($request, $priorityNumber);
  }


  protected function emailUpdate(EmailUpdateAdmissionRequest $request, $priorityNumber){
    return $this->emailUpdate->execute($request, $priorityNumber);
  }


  protected function emailValidation(EmailValidationAdmissionRequest $request){
    return $this->emailValidation->execute();
  }
  

  protected function feederSchool(FeederSchoolAdmissionRequest $request){
    return $this->feederSchool->execute($request);
  }
}
