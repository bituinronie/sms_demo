<?php

namespace App\Http\Requests\Branch;

use App\Http\Requests\ResponseRequest;

class CreateBranchRequest extends ResponseRequest
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
            'code' => ['required', 'numeric', 'digits:2', 'unique:branches,code'],
            'name' => ['required', 'string', 'unique:branches,name'],
            'type' => ['required', 'string', 'in:MAIN,SUB'],
        ];
    }
}
