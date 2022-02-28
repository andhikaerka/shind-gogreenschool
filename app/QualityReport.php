<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use \DateTimeInterface;

class QualityReport extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'quality_reports';

    protected $appends = [
        'letter',
        'document',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'has_document',
        'waste_management',
        'energy_conservation',
        'life_preservation',
        'water_conservation',
        'canteen_management',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_WASTE_MANAGEMENT = 100;
    const MAX_LENGTH_OF_ENERGY_CONSERVATION = 100;
    const MAX_LENGTH_OF_LIFE_PRESERVATION = 100;
    const MAX_LENGTH_OF_CANTEEN_MANAGEMENT = 100;
    const MAX_LENGTH_OF_WATER_CONSERVATION = 100;

    protected static function booted()
    {
        static::deleting(function ($qualityReport) {
            if ((count($qualityReport->qualityReportStudies) > 0)) {
                return false;
            } else {
                return true;
            }
        });

        static::deleted(function ($qualityReport) {
            $qualityReport->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function qualityReportStudies()
    {
        return $this->hasMany(Study::class, 'quality_report_id', 'id');
    }

    public function school_profile()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_profile_id');
    }

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }

    public function getLetterAttribute()
    {
        return $this->getMedia('letter')->last();
    }
}
