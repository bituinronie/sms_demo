<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Branch\Branch,
    App\Models\Department\Department;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "employees";

    protected $fillable = [
        'employee_number',
        'type',
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'age',
        'birth_date',
        'birth_place',
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
        'department_id',
        'branch_id',
        'image_id_front',
        'image_id_back',
        'image_signature'
    ];

    protected $hidden = [
        'id',
        'department_id',
        'branch_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    protected function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
