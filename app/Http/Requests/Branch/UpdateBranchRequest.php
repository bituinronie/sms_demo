<?php

namespace App\Http\Requests\Branch;

use App\Http\Requests\ResponseRequest;

class UpdateBranchRequest extends ResponseRequest
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
            'name' => ['required', 'string', 'unique:branches,name,'.$this->getBranchId($this->branchCode)],
            'type' => ['sometimes', 'required', 'string', 'in:MAIN,SUB'],
        ];
    }
}
