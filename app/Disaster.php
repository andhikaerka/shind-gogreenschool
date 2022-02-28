<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Disaster extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia, Activable;

    public $table = 'disasters';

    protected $appends = [
        'photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'threat',
        'potential',
        'anticipation',
        'vulnerability',
        'impact',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_THREAT = 100;
    const MAX_LENGTH_OF_POTENTIAL = 100;
    const MAX_LENGTH_OF_VULNERABILITY = 100;
    const MAX_LENGTH_OF_IMPACT = 100;

    protected static function booted()
    {
        static::deleted(function ($disaster) {
            $disaster->clearMediaCollection();
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

    /*public function threats()
    {
        return $this->belongsToMany(DisasterThreat::class);
    }*/

    public function getPhotoAttribute()
    {
        return $this->getMedia('photo')->last();
    }

}
