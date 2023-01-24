<?php

namespace App\Http\Requests\Building;

use App\Http\Requests\ResponseRequest;

class CreateBuildingRequest extends ResponseRequest
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
            'code'   => ['required', 'string', 'unique:buildings,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'name'   => ['required', 'string', 'unique:buildings,name,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'branch' => ['required', 'string'],
        ];
    }
}
