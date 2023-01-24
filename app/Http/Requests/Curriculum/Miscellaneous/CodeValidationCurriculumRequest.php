<?php

namespace App\Http\Requests\Curriculum\Miscellaneous;

use App\Http\Requests\ResponseRequest;

class CodeValidationCurriculumRequest extends ResponseRequest
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
            'code' => ['required', 'string', 'unique:curriculums,code,NULL,id,branch_id,'.$this->getBranchId($this->branch)],
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.unique' => 'Curriculum code is already in use'
        ];
    }
}
