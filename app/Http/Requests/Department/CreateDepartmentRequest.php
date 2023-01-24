<?php

namespace App\Http\Requests\Department;

use App\Http\Requests\ResponseRequest;

class CreateDepartmentRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('user')->user()->hasRole(['ADMIN']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'     => ['required', 'string', 'unique:departments,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'name'     => ['required', 'string', 'unique:departments,name,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'employee' => ['sometimes', 'required', 'string'],
            'type'     => ['required', 'string', 'in:ACADEMIC,NON-ACADEMIC'],
            'branch'   => ['required', 'string'],
        ];
    }
}
