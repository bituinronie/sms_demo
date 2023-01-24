<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\ResponseRequest;

class CreateSubjectRequest extends ResponseRequest
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
            'code'           => ['required', 'string', 'unique:subjects,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'name'           => ['required', 'string', 'unique:subjects,name,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
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
