<?php

namespace App\Http\Requests\Strand;

use App\Http\Requests\ResponseRequest;

class CreateStrandRequest extends ResponseRequest
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
            'code'   => ['required', 'unique:strands,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'name'   => ['required', 'unique:strands,name,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'track'  => ['required', 'string', 'in:ACADEMIC,TECHNICAL VOCATIONAL LIVELIHOOD,ARTS AND DESIGN,SPORTS'],
            'branch' => ['required', 'string'],
        ];
    }
}
