<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use \DateTimeInterface;

class Extracurricular extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'extracurriculars';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'program',
        'tutor',
        'time',
        'activity',
        'target',
        'created_at',
        'updated_at'
    ];

    const MAX_LENGTH_OF_PROGRAM = 100;
    const MAX_LENGTH_OF_TUTOR = 100;
    const MAX_LENGTH_OF_TIME = 100;
    const MAX_LENGTH_OF_ACTIVITY = 150;
    const MAX_LENGTH_OF_TARGET = 150;

    protected static function booted()
    {
        static::deleted(function ($environmentIssue) {
            $environmentIssue->clearMediaCollection();
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

    public function getLetterAttribute()
    {
        return $this->getMedia('letter')->last();
    }

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }

    public function participants()
    {
        return $this->belongsToMany(TeamStatus::class);
    }
}
