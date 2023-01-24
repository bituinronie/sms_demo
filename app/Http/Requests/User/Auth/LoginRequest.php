<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\ResponseRequest;

class LoginRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employeeNumber' => ['required', 'string', 'size:10'],
            'password'       => ['required']
        ];
    }
}
