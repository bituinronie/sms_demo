<?php

namespace App\Models\Admission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admission\ApplicantPersonalInformation,
    App\Models\Program\Program,
    App\Models\Strand\Strand,
    App\Models\Branch\Branch;

class ApplicantAdmission extends Model
{
    use HasFactory;

    protected $table      = 'applicant_admissions';
    public    $timestamps = false;

    protected $fillable = [
            'applicant_id',
            'priority_number',
            'applicant_status',
            'remark',
            'student_type',
            'method_teaching',
            'semester',
            'branch_id',
            'learner_reference_number',
            'education_level',
            'grade_year_level',
            'strand_id',
            'program_id',
            'school_year',
            'previous_school_type',
            'voucher'
    ];

    protected $hidden = [
        'id',
        'applicant_id',
        'branch_id',
        'strand_id',
        'program_id'
    ];

    protected function personal() {
        return $this->belongsTo(ApplicantPersonalInformation::class, 'applicant_id');
    }

    protected function program() {
        return $this->belongsTo(Program::class, 'program_id');
    }

    protected function strand() {
        return $this->belongsTo(Strand::class, 'strand_id');
    }

    protected function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
