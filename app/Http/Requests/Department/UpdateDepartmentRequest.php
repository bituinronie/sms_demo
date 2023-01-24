<?php

namespace App\Http\Requests\Department;

use App\Http\Requests\ResponseRequest;

class UpdateDepartmentRequest extends ResponseRequest
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
            'code'   => ['required', 'string', 'unique:departments,code,'.$this->getDepartmentId($this->getBranchId($this->branchCode), $this->departmentCode).',id,branch_id,'.$this->getBranchId($this->branch)],
            'name'   => ['required', 'string', 'unique:departments,name,'.$this->getDepartmentId($this->getBranchId($this->branchCode), $this->departmentCode).',id,branch_id,'.$this->getBranchId($this->branch)],
            'type'   => ['required', 'string', 'in:ACADEMIC,NON-ACADEMIC'],
            'branch' => ['required', 'string'],
        ];
    }
}
