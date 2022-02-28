<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class Partner extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'partners';

    protected $appends = [
        'photo',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'name',
        'cp_name',
        'cp_phone',
        'partner_category_id',
        'partner_activity_id',
        'date',
        'purpose',
        'total_people',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_NAME = 100;
    const MAX_LENGTH_OF_CP_NAME = 100;
    const MAX_LENGTH_OF_PURPOSE = 100;

    protected static function booted()
    {
        static::deleting(function ($partner) {
            foreach ($partner->partnerStudies as $study) {
                $study->delete();
            }
        });

        static::deleted(function ($partner) {
            $partner->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function partnerStudies()
    {
        return $this->hasMany(Study::class, 'partner_id', 'id');
    }

    public function school_profile()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_profile_id');
    }

    public function partner_category()
    {
        return $this->belongsTo(PartnerCategory::class, 'partner_category_id');
    }

    public function partner_activity()
    {
        return $this->belongsTo(PartnerActivity::class, 'partner_activity_id');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPhotoAttribute()
    {
        return $this->getMedia('photo')->last();
    }
}
