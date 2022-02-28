<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use \DateTimeInterface;
use Carbon\Carbon;

class EnvironmentalIssue extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'environmental_issues';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'potency',
        'date',
        'category',
        'problem',
        'anticipation',
        'compiler',
        'created_at',
        'updated_at'
    ];

    const MAX_LENGTH_OF_POTENCY = 100;
    const LIST_OF_CATEGORY = ['Lokal', 'Daerah', 'Nasional', 'Global'];
    const MAX_LENGTH_OF_PROBLEM = 150;
    const MAX_LENGTH_OF_ANTICIPATION = 150;
    const MAX_LENGTH_OF_COMPILER = 150;

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

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
