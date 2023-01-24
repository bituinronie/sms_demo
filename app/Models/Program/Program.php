<?php

namespace App\Models\Program;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Branch\Branch,
    App\Models\Employee\Employee,
    App\Models\Department\Department;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "programs";

    protected $fillable = [
        'code',
        'name',
        'type',
        'duration',
        'employee_id',
        'department_id',
        'branch_id'
    ];

    protected $hidden = [
        'id',
        'employee_id',
        'department_id',
        'branch_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];


    protected function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    protected function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

    protected function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
