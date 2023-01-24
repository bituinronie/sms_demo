<?php

namespace App\Models\Curriculum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Curriculum\Curriculum,
    App\Models\Subject\Subject;

class CurriculumSubject extends Model
{
    use HasFactory;

    protected $table      = "curriculum_subjects";
    public    $timestamps = false;

    protected $fillable = [
        'curriculum_id',
        'subject_id',
        'prerequisite_subject_id',
        'corequisite_subject_id',
        'alias',
        'year_level',
        'semester'
    ];

    protected $hidden = [
        'id',
        'curriculum_id',
        'subject_id',
        'prerequisite_subject_id',
        'corequisite_subject_id'
    ];

    protected function curriculum() {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }
    
    protected function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    protected function prerequisite() {
        return $this->belongsTo(Subject::class, 'prerequisite_subject_id');
    }

    protected function corequisite() {
        return $this->belongsTo(Subject::class, 'corequisite_subject_id');
    }
}
