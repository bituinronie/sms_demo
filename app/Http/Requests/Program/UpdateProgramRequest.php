<?php

namespace App\Http\Requests\Program;

use App\Http\Requests\ResponseRequest;

class UpdateProgramRequest extends ResponseRequest
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
            'code'       => ['required', 'unique:programs,code,'.$this->getProgramId($this->getBranchId($this->branchCode), $this->programCode).',id,branch_id,'.$this->getBranchId($this->branch)],
            'name'       => ['required', 'unique:programs,name,'.$this->getProgramId($this->getBranchId($this->branchCode), $this->programCode).',id,branch_id,'.$this->getBranchId($this->branch)],
            'type'       => ['required', 'string', 'in:UNDERGRADUATE,POSTGRADUATE'],
            'duration'   => ['required', 'integer'],
            'employee'   => ['nullable', 'string'],
            'department' => ['required', 'string'],
            'branch'     => ['required', 'string'],
        ];
    }
}
