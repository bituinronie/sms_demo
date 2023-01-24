<?php

namespace App\Http\Requests\Section;

use App\Http\Requests\ResponseRequest;

class CreateSectionRequest extends ResponseRequest
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
            'code'           => ['required', 'string', 'unique:sections,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
            'type'           => ['required', 'string', 'in:COLLEGE,BASIC EDUCATION'],
            'yearLevel'      => ['required', 'string'],
            'semester'       => ['nullable', 'string'],
            'classSize'      => ['required', 'integer'],
            'branch'         => ['required', 'string'],
            'department'     => ['required', 'string'],
        ];
    }
}
