<?php

namespace App\Http\Requests\InformationTechnologyServices\User;

use App\Http\Requests\ResponseRequest;

class RegisterUserAccountRequest extends ResponseRequest
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
            'employeeNumber' => [
                'required', 
                'string', 
                'unique:user_accounts,employee_number',
                'exists:employees,employee_number'
            ],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', 'in:ADMIN,ACCOUNTING,ADMISSION,AUDITOR,BASIC EDUCATION,CASHIER,DEAN,FACULTY,FOREIGN,HUMAN RESOURCE,INFORMATION TECHNOLOGY SERVICE,PROGRAM HEAD,REGISTRAR,SECRETARY,SCHOLARSHIP']
        ];
    }
}
