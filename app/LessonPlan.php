<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class LessonPlan extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'lesson_plans';

    protected $appends = [
        'rpp',
        'syllabus',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const PERIOD_SELECT = [
        '1' => 'Semester Ganjil',
        '2' => 'Semester Genap',
    ];

    protected $fillable = [
        'school_profile_id',
        'environmental_issue_id',
        'subject',
        'teacher',
        'class',
        'period',
        'aspect_id',
        'hook',
        'artwork',
        'hour',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const CLASS_SELECT = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
    ];

    const MAX_LENGTH_OF_SUBJECT = 35;
    const MAX_LENGTH_OF_TEACHER = 35;
    const MAX_LENGTH_OF_HOOK = 100;
    const MAX_LENGTH_OF_ARTWORK = 100;

    protected static function booted()
    {
        static::deleted(function ($lessonPlan) {
            $lessonPlan->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function school_profile()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_profile_id');
    }

    public function environmentalIssue()
    {
        return $this->belongsTo(EnvironmentalIssue::class, 'environmental_issue_id');
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class, 'aspect_id');
    }

    public function getSyllabusAttribute()
    {
        return $this->getMedia('syllabus')->last();
    }

    public function getRppAttribute()
    {
        return $this->getMedia('rpp')->last();
    }
}
