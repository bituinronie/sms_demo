<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantEducationBackground extends Model
{
    use HasFactory;

    protected $table      = 'applicant_education_backgrounds';
    public    $timestamps = false;

    protected $fillable = [
        'applicant_id',
        'elementary_name',
        'elementary_address',
        'elementary_year_completed',
        'junior_high_school_name',
        'junior_high_school_address',
        'junior_high_school_year_completed',
        'senior_high_school_name',
        'senior_high_school_strand',
        'senior_high_school_address',
        'senior_high_school_year_completed',
        'college_name',
        'college_course',
        'college_address',
        'college_year_completed',
        'previous_school'
    ];

    protected $hidden = [
        'id',
        'applicant_id'
    ];
}
