<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Employee\Employee;

class UserAccount extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $table = 'user_accounts';
  
    protected $fillable = [
        'employee_id',
        'employee_number',
        'password',
        'last_login'
    ];

    
    protected $hidden = [
        'id',
        'employee_id',
        'password',
        'last_login',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
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
