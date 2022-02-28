<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Curriculum extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'curricula';

    protected $appends = [
        'document',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'vision',
        'mission',
        'purpose',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_VISION = 100;
    const MAX_LENGTH_OF_MISSION = 100;
    const MAX_LENGTH_OF_PURPOSE = 100;

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

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }

    public function calendars()
    {
        return $this->belongsToMany(CurriculumCalendar::class);
    }
}
