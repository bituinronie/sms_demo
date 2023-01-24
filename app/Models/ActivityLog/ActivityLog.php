<?php

namespace App\Models\ActivityLog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User\UserAccount,
    App\Models\Student\StudentAccount;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = "activity_logs";

    const  UPDATED_AT  = NULL;

    protected $fillable = [
        'user_id', 
        'student_id',
        'action',
        'module',
        'message',
        'causeTo',
        'data'
    ];

    protected $hidden = [
        'id',
        'user_id',
        'student_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'causeTo' => 'array',
        'data'    => 'array'
    ];

    protected function user() {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }


    protected function student() {
        return $this->belongsTo(StudentAccount::class, 'student_id');
    }
}
