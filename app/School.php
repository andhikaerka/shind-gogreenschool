<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use \DateTimeInterface;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class School extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use HasSlug;
    use Activable;

    const MAX_LENGTH_OF_NAME = 35;
    const MAX_LENGTH_OF_ADDRESS = 50;
    const MAX_LENGTH_OF_EMAIL = 35;
    const MAX_LENGTH_OF_WEBSITE = 35;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public $table = 'schools';

    protected $appends = [
        'logo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'Negeri' => 'Negeri',
        'Swasta' => 'Swasta',
    ];

    const LEVEL_SELECT = [
        'SD' => 'SD (atau sederajat)',
        'SMP' => 'SMP (atau sederajat)',
        'SMA' => 'SMA (atau sederajat)',
    ];

    const APPROVAL_CONDITION_SELECT = [
        'A' => 'Perencanaan',
        'B' => 'Perencanaan & Pelaksanaan',
        'C' => 'Perencanaan, Pelaksanaan & Monev',
        'D' => 'Perencanaan, Pelaksanaan, Monev & Penilaian Akhir',
    ];

    protected $fillable = [
        'user_id',
        'city_id',
        'slug',
        'name',
        'level',
        'status',
        'address',
        'phone',
        'email',
        'website',
        'approval_condition',
        'approval_time',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected static function booted()
    {
        static::deleting(function ($school) {
            if ((count($school->schoolInfrastructures ?? []) > 0) ||
                (count($school->schoolDisasters ?? []) > 0) ||
                (count($school->schoolQualityReports ?? []) > 0) ||
                (count($school->schoolTeams ?? []) > 0) ||
                (count($school->schoolPartners ?? []) > 0) ||
                (count($school->schoolWorkGroups ?? []) > 0) ||
                (count($school->schoolBudgetPlans ?? []) > 0) ||
                (count($school->schoolLessonPlans ?? []) > 0)) {
                return false;
            } else {
                return true;
            }
        });

        static::deleted(function ($school) {
            $school->clearMediaCollection();

            User::query()->find($school['user_id'])->delete();
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

    public function schoolSchoolProfiles()
    {
        return $this->hasMany(SchoolProfile::class, 'school_id', 'id');
    }

    public function getLogoAttribute()
    {
        $file = $this->getMedia('logo')->last();

        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
