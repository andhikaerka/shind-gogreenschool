<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class Infrastructure extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'infrastructures';

    protected $appends = [
        'photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'total',
        'aspect_id',
        'function',
        'created_at',
        'updated_at',
        'deleted_at',
        'work_group_id',
        'pic',
    ];

    const MAX_LENGTH_OF_NAME = 50;
    const MAX_LENGTH_OF_FUNCTION = 100;
    const MAX_LENGTH_OF_PIC = 35;

    protected static function booted()
    {
        static::deleted(function ($infrastructure) {
            $infrastructure->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /*public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }*/

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class, 'aspect_id');
    }

    public function getPhotoAttribute()
    {
        return $this->getMedia('photo')->last();
    }
}
