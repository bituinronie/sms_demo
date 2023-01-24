<?php

namespace App\Models\Room;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Branch\Branch,
    App\Models\Laboratory\Laboratory,
    App\Models\Building\Building;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "rooms";

    protected $fillable = [
        'code',
        'name',
        'type',
        'branch_id',
        'laboratory_id',
        'building_id'
    ];

    protected $hidden = [
        'id',
        'branch_id',
        'laboratory_id',
        'building_id',
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

    protected function building() {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
