<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator,
    Illuminate\Foundation\Http\FormRequest,
    Illuminate\Http\Exceptions\HttpResponseException,
    Illuminate\Auth\Access\AuthorizationException;


use App\Models\Admission\ApplicantPersonalInformation,
    App\Models\Admission\ApplicantAdmission,
    App\Models\Laboratory\Laboratory,
    App\Models\Department\Department,
    App\Models\Building\Building,
    App\Models\Curriculum\Curriculum,
    App\Models\Employee\Employee,
    App\Models\Program\Program,
    App\Models\Subject\Subject,
    App\Models\Branch\Branch,
    App\Models\Strand\Strand,
    App\Models\Room\Room,
    App\Models\Section\Section;
/**
 * use App\Http\Requests\ResponseRequest
 * Extend this to your Requests instead of FormRequest in order to use
 */

abstract class ResponseRequest extends FormRequest
{

    //*********************************************** DRY FUNCTION ***********************************************// 

    protected function getPersonalId($priorityNumber){
        $admission = ApplicantAdmission::where("priority_number", "=", $priorityNumber)->firstOrFail();
        $personal  = ApplicantPersonalInformation::where("id", "=", $admission->applicant_id)->firstOrFail();
        return $personal->id;
    }

    
    protected function getBranchId($branchCode){
        $branch = Branch::where('code', '=', $branchCode)->firstOrFail();
        return $branch->id;
    }


    protected function getBuildingBranchId($buildingCode){
        $building = Building::where('code', '=', strtoupper($buildingCode))->firstOrFail();
        return $building->branch->id;
    }


    protected function getBuildingId($branchId, $buildingCode){
        $building = Building::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($buildingCode))->firstOrFail();
        return $building->id;
    }


    protected function getDepartmentId($branchId, $departmentCode){
        $department = Department::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($departmentCode))->firstOrFail();
        return $department->id;
    }


    protected function getEmployeeId($employeeNumber){
        $employee = Employee::where('employee_number', '=', $employeeNumber)->firstOrFail();
        return $employee->id;
    }


    protected function getLaboratoryId($branchId, $laboratoryCode){
        $laboratory = Laboratory::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($laboratoryCode))->firstOrFail();
        return $laboratory->id;
    }


    protected function getProgramId($branchId, $programCode){
        $program = Program::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($programCode))->firstOrFail();
        return $program->id;
    }


    protected function getRoomId($branchId, $roomCode){
        $room = Room::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($roomCode))->firstOrFail();
        return $room->id;
    }


    protected function getStrandId($branchId, $strandCode){
        $strand = Strand::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($strandCode))->firstOrFail();
        return $strand->id;
    }


    protected function getSubjectId($branchId, $subjectCode){
        $subject = Subject::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($subjectCode))->firstOrFail();
        return $subject->id;
    }


    protected function getCurriculumId($branchId, $curriculumCode){
        $curriculum = Curriculum::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($curriculumCode))->firstOrFail();
        return $curriculum->id;
    }


    protected function getSectionId($branchId, $sectionCode){
        $section = Section::where('branch_id', '=', $branchId)->where('code', '=', strtoupper($sectionCode))->firstOrFail();
        return $section->id;
    }
    
    //*********************************************** EXCEPTION ***********************************************// 
    /**
     * Determine if user authorized to make this request
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * If authorization fails return the exception in json form
     * @return array
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json(
            [
                'message'   =>  "You have no permission to access the following data",
                'results'   =>  [],
                'code'      =>  403,
                'errors'    =>  true,
            ],
            403));
    }

    /**
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {

        $errors     =   [];

        foreach($validator->errors()->messages() as $key => $value)
        {
            $errors[$key]  = $value[0];  
        }

        throw new HttpResponseException(response()->json(
            [
                'message'   =>  "Something went wrong",
                'results'   =>  $errors,
                'code'      =>  422,
                'errors'    =>  true,
            ],
            422));
    }

    abstract public function rules();
}
