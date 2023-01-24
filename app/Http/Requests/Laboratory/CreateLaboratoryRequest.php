<?php

namespace App\Http\Requests\Laboratory;

use App\Http\Requests\ResponseRequest;

class CreateLaboratoryRequest extends ResponseRequest
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
            'code'   => ['required', 'string', 'unique:laboratories,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'name'   => ['required', 'string', 'unique:laboratories,name,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'amount' => ['nullable', 'numeric'], 
            'branch' => ['required', 'string'],
        ];
    }
}
