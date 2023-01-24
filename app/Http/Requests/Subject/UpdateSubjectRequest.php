<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\ResponseRequest;

class UpdateSubjectRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('user')->user()->hasRole(['PROGRAM HEAD', 'ADMIN']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'           => ['required', 'unique:subjects,code,'.$this->getSubjectId($this->getBranchId($this->branchCode), $this->subjectCode).',id,branch_id,'.$this->getBranchId($this->branch)],
            'name'           => ['required', 'unique:subjects,name,'.$this->getSubjectId($this->getBranchId($this->branchCode), $this->subjectCode).',id,branch_id,'.$this->getBranchId($this->branch)],
            'type'           => ['required', 'string', 'in:PROFESSIONAL EDUCATION,GENERAL EDUCATION,NSTP'],
            'lectureUnit'    => ['required', 'integer'],
            'lectureHour'    => ['required', 'numeric'],
            'laboratoryUnit' => ['nullable', 'integer'],
            'laboratoryHour' => ['nullable', 'numeric'],
            'branch'         => ['required', 'string'],
            'laboratory'     => ['nullable', 'string'],
            'department'     => ['required', 'string'],
        ];
    }
}
