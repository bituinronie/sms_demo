<?php

namespace App\Http\Requests\InformationTechnologyServices\Student;

use App\Http\Requests\ResponseRequest;

class RegisterStudentAccountRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('user')->user()->hasRole(['INFORMATION TECHNOLOGY SERVICE', 'ADMIN']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'studentNumber' => [
                'required', 
                'string', 
                'unique:student_accounts,student_number',
                'exists:applicant_admissions,priority_number'
            ],
            'password' => ['required', 'string', 'min:8']
        ];
    }
}
