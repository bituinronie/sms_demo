<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicantPersonalInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'applicant_personal_informations';

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'age',
        'birth_date',
        'birth_place',
        'telephone_number',
        'mobile_number',
        'email_address',
        'civil_status',
        'nationality',
        'religion',
        'current_address_house_number',
        'current_address_street_name',
        'current_address_barangay',
        'current_address_city',
        'current_address_province',
        'current_address_zip_code',
        'permanent_address_house_number',
        'permanent_address_street_name',
        'permanent_address_barangay',
        'permanent_address_city',
        'permanent_address_province',
        'permanent_address_zip_code',
        'father_full_name',
        'father_occupation',
        'father_address',
        'father_contact_number',
        'father_email',
        'mother_full_name',
        'mother_occupation',
        'mother_address',
        'mother_contact_number',
        'mother_email',  
        'guardian_full_name',
        'guardian_relationship',
        'guardian_occupation',
        'guardian_address',
        'guardian_contact_number',
        'guardian_email',
        'parents_or_guardian_average_income',
        'other_average_income'
    ];

    protected $hidden = [
      'id'
    ];

    protected function admission() {
        return $this->hasOne(ApplicantAdmission::class, 'applicant_id');
    }
  
    protected function education() {
      return $this->hasOne(ApplicantEducationBackground::class, 'applicant_id');
    }

    protected function requirement() {
      return $this->hasOne(ApplicantRequirement::class, 'applicant_id');
    }
}
