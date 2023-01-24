<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Admission\ApplicantPersonalInformation;

class StudentAccount extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $table = 'student_accounts';

    protected $fillable = [
        'applicant_id',
        'student_number',
        'password',
        'last_login'
    ];

    protected $hidden = [
        'id',
        'password',
        'last_login',
        'applicant_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function personal() {
        return $this->belongsTo(ApplicantPersonalInformation::class, 'applicant_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
