<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Section\Section,
    App\Models\Subject\Subject,
    App\Models\Employee\Employee,
    App\Models\Branch\Branch,
    App\Models\Schedule\ScheduleDate;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "schedules";

    protected $fillable = [
        'code',
        'branch_id',
        'section_id',
        'subject_id',
        'employee_id'
    ];

    protected $hidden = [
        'id',
        'branch_id',
        'section_id',
        'subject_id',
        'employee_id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    protected function section() {
        return $this->belongsTo(Section::class, 'section_id');
    }

    protected function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    protected function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    protected function scheduleDate() {
        return $this->hasMany(ScheduleDate::class, 'schedule_id');
    }
}
