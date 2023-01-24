<?php

namespace App\Models\Department;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Branch\Branch,
    App\Models\Employee\Employee;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "departments";

    protected $fillable = [
        'code',
        'name',
        'employee_id',
        'type',
        'branch_id'
    ];

    protected $hidden = [
        'id',
        'employee_id',
        'branch_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    protected function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
