<?php

namespace App\Http\Requests\Admission\Online;

use App\Http\Requests\ResponseRequest;

class CreateOnlineAdmissionRequest extends ResponseRequest
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
            'studentType'        => ['required', 'string', 'in:NEW,TRANSFEREE,SECOND COURSER,OLD'],
            'applicantStatus'    => ['nullable', 'in:PENDING,ACCEPTED,ASSIGNED,OFFICIAL,ARCHIVED,DENIED'],
            'methodTeaching'     => ['required', 'string', 'in:ONLINE,MODULAR,MODULAR AND ONLINE'],
            'educationLevel'     => ['required', 'string', 'in:PRE-SCHOOL,ELEMENTARY,JUNIOR HIGH SCHOOL,SENIOR HIGH SCHOOL,COLLEGE,GRADUATE SCHOOL'],
            'branch'             => ['required', 'string'],
            'semester'           => ['nullable', 'string', 'in:FIRST SEMESTER,SECOND SEMESTER,SUMMER'],
            'voucherFile'        => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'schoolYear'         => ['required', 'string'],
            'previousSchoolType' => ['nullable', 'in:PUBLIC SCHOOL,PRIVATE SCHOOL'],

            'lastName'                       => ['required', 'string'],
            'firstName'                      => ['required', 'string'],
            'gender'                         => ['required', 'string', 'in:MALE,FEMALE'],
            'birthDate'                      => ['required', 'date'],
            'birthPlace'                     => ['required', 'string'],
            'mobileNumber'                   => ['required', 'digits:10'],
            'emailAddress'                   => ['required', 'email', 'unique:applicant_personal_informations,email_address'],
            'civilStatus'                    => ['required', 'string', 'in:SINGLE,MARRIED,DIVORCED,SEPARATED,WIDOWED'],
            'nationality'                    => ['required', 'string'],
            'currentAddressHouseNumber'      => ['required'],
            'currentAddressStreetName'       => ['required', 'string'],
            'currentAddressBarangay'         => ['required', 'string'],
            'currentAddressCity'             => ['required', 'string'],
            'currentAddressProvince'         => ['required', 'string'],
            'permanentAddressHouseNumber'    => ['required'],
            'permanentAddressStreetName'     => ['required', 'string'],
            'permanentAddressBarangay'       => ['required', 'string'],
            'permanentAddressCity'           => ['required', 'string'],
            'permanentAddressProvince'       => ['required', 'string'],
            'guardianFullName'               => ['required', 'string'],
            'guardianRelationship'           => ['required', 'string'],
            'guardianAddress'                => ['required', 'string'],
            'guardianContactNumber'          => ['required', 'digits:10'],
            'parentsOrGuardianAverageIncome' => ['required', 'string'],

            'profileImage'                 => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:5000'],
            'spcfCatResult'                => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'certificateOfMoralCharacter'  => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'nsoBirthCertificate'          => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'form137'                      => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'policeClearance'              => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'barangayClearance'            => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'transferCredential'           => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'specialStudyPermit'           => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'alienCertificateRegistration' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'passport'                     => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'visa'                         => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'medicalClearance'             => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'transcriptOfRecord'           => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000'],
            'marriageCertificate'          => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5000']
        ];
    }
}
