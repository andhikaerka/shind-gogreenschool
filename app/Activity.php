<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Activity extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia, Activable;

    public $table = 'activities';

    protected $appends = [
        'document',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'date',
        'work_group_id',
        'activity',
        'advantage',
        'behavioral',
        'physical',
        'tutor',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_NAME = 100;
    const MAX_LENGTH_OF_ACTIVITY = 100;
    const MAX_LENGTH_OF_ADVANTAGE = 100;
    const MAX_LENGTH_OF_BEHAVIORAL = 100;
    const MAX_LENGTH_OF_PHYSICAL = 100;
    const MAX_LENGTH_OF_TUTOR = 35;

    protected static function booted()
    {
        static::deleted(function ($activity) {
            $activity->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function team_statuses()
    {
        return $this->belongsToMany(TeamStatus::class);
    }

}
