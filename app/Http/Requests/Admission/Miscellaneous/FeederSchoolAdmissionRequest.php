<?php

namespace App\Http\Requests\Admission\Miscellaneous;

use App\Http\Requests\ResponseRequest;

class FeederSchoolAdmissionRequest extends ResponseRequest
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
            'branch'         => ['required'],
            'educationLevel' => ['required', 'in:ALL,PRE-SCHOOL,ELEMENTARY,JUNIOR HIGH SCHOOL,SENIOR HIGH SCHOOL,COLLEGE,GRADUATE SCHOOL'],
            'semester'       => ['required', 'in:ALL,FIRST SEMESTER,SECOND SEMESTER,SUMMER'],
            'startDate'      => ['required', 'date'],
            'endDate'        => ['required', 'date'],
        ];
    }
}
