<?php

namespace App\Http\Requests\Admission\Miscellaneous;

use App\Http\Requests\ResponseRequest;

class EmailValidationAdmissionRequest extends ResponseRequest
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
            'emailAddress' => ['required', 'email', 'unique:applicant_personal_informations,email_address'],
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
            'emailAddress.unique' => 'Email is already in use'
        ];
    }
}
