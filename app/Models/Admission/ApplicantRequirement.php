<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantRequirement extends Model
{
    use HasFactory;

    protected $table      = 'applicant_requirements';
    public    $timestamps = false;

    protected $fillable = [
        'applicant_id',
        'profile_image',
        'spcf_cat_result',
        'certificate_of_moral_character',
        'nso_birth_certificate',
        'form_137',
        'police_clearance',
        'barangay_clearance',
        'transfer_credential',
        'special_study_permit',
        'alien_certificate_registration',
        'passport',
        'visa',
        'medical_clearance',
        'transcript_of_record',
        'marriage_certificate'
    ];

    protected $hidden = [
        'id',
        'applicant_id'
    ];
}
