<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\ResponseRequest;

class UpdateEmployeeRequest extends ResponseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('user')->user()->hasRole(['HUMAN RESOURCE', 'ADMIN']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'                        => ['required', 'string', 'in:TEACHING,NON-TEACHING,DEAN'],
            'lastName'                    => ['required', 'string'],
            'firstName'                   => ['required', 'string'],
            'middleName'                  => ['nullable', 'string'],
            'gender'                      => ['required', 'string', 'in:MALE,FEMALE'],
            'birthDate'                   => ['required', 'date'],
            'birthPlace'                  => ['required', 'string'],
            'mobileNumber'                => ['required', 'digits:10'],
            'emailAddress'                => ['required', 'email', 'unique:employees,email_address,'.$this->getEmployeeId($this->employeeNumber)],
            'civilStatus'                 => ['required', 'string', 'in:SINGLE,MARRIED,DIVORCED,SEPARATED,WIDOWED'],
            'nationality'                 => ['required', 'string'],
            'religion'                    => ['nullable', 'string'],
            'currentAddressHouseNumber'   => ['required', 'string'],
            'currentAddressStreetName'    => ['required', 'string'],
            'currentAddressBarangay'      => ['required', 'string'],
            'currentAddressCity'          => ['required', 'string'],
            'currentAddressProvince'      => ['required', 'string'],
            'currentAddressZipCode'       => ['nullable', 'string'],
            'permanentAddressHouseNumber' => ['required', 'string'],
            'permanentAddressStreetName'  => ['required', 'string'],
            'permanentAddressBarangay'    => ['required', 'string'],
            'permanentAddressCity'        => ['required', 'string'],
            'permanentAddressProvince'    => ['required', 'string'],
            'permanentAddressZipCode'     => ['nullable', 'string'],
            'department'                  => ['required', 'string'],
            'branch'                      => ['required', 'string'],
            'imageIdFront'                => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:5000'],
            'imageIdBack'                 => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:5000'],
            'imageSignature'              => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:5000']
        ];
    }
}
