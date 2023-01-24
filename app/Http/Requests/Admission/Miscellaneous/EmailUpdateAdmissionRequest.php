<?php

namespace App\Http\Requests\Admission\Miscellaneous;

use App\Http\Requests\ResponseRequest;

class EmailUpdateAdmissionRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('user')->user()->hasRole(['ADMISSION', 'ADMIN']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'emailAddress' => ['required', 'email', 'unique:applicant_personal_informations,email_address,'.$this->getPersonalId($this->priorityNumber)],
        ];
    }

}
