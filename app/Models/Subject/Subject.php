<?php

namespace App\Models\Subject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Branch\Branch,
    App\Models\Laboratory\Laboratory,
    App\Models\Department\Department;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "subjects";
    
    protected $fillable = [
        'code', 
        'name',
        'type',
        'lecture_unit',
        'lecture_hour',
        'laboratory_unit',
        'laboratory_hour',
        'branch_id',
        'laboratory_id',
        'department_id'
    ];
                                                
    protected $hidden = [
        'id',
        'branch_id',
        'laboratory_id',
        'department_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    protected function laboratory() {
        return $this->belongsTo(Laboratory::class, 'laboratory_id');
    }

    protected function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
