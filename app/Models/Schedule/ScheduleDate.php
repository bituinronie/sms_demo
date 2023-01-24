<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Room\Room,
    App\Models\Schedule\Schedule;

class ScheduleDate extends Model
{
    use HasFactory;

    protected $table      = "schedule_dates";
    public    $timestamps = false;
    
    protected $fillable = [
        'schedule_id',
        'room_id',
        'day',
        'time_start',
        'time_end'
    ];

    protected $hidden = [
        'id',
        'schedule_id',
        'room_id',
    ];

    protected function schedule() {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
    
    protected function room() {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
