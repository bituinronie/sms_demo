<?php

namespace App\Http\Requests\Curriculum;

use App\Http\Requests\ResponseRequest;

class UpdateCurriculumRequest extends ResponseRequest
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
            'code'              => ['required', 'string', 'unique:curriculums,code,'.$this->getCurriculumId($this->getBranchId($this->branchCode), $this->curriculumCode).',id,branch_id,'.$this->getBranchId($this->branch)],
            'type'              => ['required', 'string', 'in:COLLEGE,BASIC EDUCATION'],
            'branch'            => ['required', 'string'],
            'department'        => ['required', 'string'],
            'program'           => ['required', 'string']
        ];
    }
}
