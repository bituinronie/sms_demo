<?php

namespace App\Http\Requests\Program;

use App\Http\Requests\ResponseRequest;

class CreateProgramRequest extends ResponseRequest
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
            'code'       => ['required', 'string', 'unique:programs,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'name'       => ['required', 'string', 'unique:programs,name,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'type'       => ['required', 'string', 'in:UNDERGRADUATE,POSTGRADUATE'],
            'duration'   => ['required', 'integer'],
            'employee'   => ['nullable', 'string'],
            'department' => ['required', 'string'],
            'branch'     => ['required', 'string'],
        ];
    }
}
