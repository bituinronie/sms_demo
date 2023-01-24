<?php

namespace App\Http\Requests\Admission\Miscellaneous;

use App\Http\Requests\ResponseRequest;

class StatusAdmissionRequest extends ResponseRequest
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
            'applicantStatus' => ['required', 'string', 'in:PENDING,ACCEPTED,ASSIGNED,OFFICIAL,ARCHIVED,DENIED'],
            'remark'          => ['required', 'string']
        ];
    }
}
