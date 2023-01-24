<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Branch\Branch,
    App\Models\Department\Department,
    App\Models\Schedule\Schedule;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sections";

    protected $fillable = [
        'code',
        'type',
        'year_level',
        'semester',
        'class_size',
        'branch_id',
        'department_id'
    ];

    protected $hidden = [
        'id',
        'branch_id',
        'department_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

    protected function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    protected function schedule() {
        return $this->hasMany(Schedule::class, 'section_id');
    }
}
