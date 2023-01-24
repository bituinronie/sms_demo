<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Admission\ApplicantPersonalInformation;

class ProofOfPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "accounting_proof_of_payments";
    
    protected $fillable = [
        'applicant_id',
        'payment_code',
        'payment_option',
        'other',
        'amount',
        'payment_status',
        'remark',
        'payment_receipt',
        'education_level',
        'grade_year_level',
        'semester',
        'school_year'
    ];
                                                
    protected $hidden = [
        'id',
        'applicant_id'
    ];

    protected function personal() {
        return $this->belongsTo(ApplicantPersonalInformation::class, 'applicant_id');
    }

}
