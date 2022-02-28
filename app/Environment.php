<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use \DateTimeInterface;

class Environment extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'environments';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'compiler',
        'isi',
        'proses',
        'kompetensi_kelulusan',
        'pendidik_dan_tenaga_kependidikan',
        'sarana_prasarana',
        'pengelolaan',
        'pembiayaan',
        'penilaian_pendidikan',
        'created_at',
        'updated_at'
    ];

    const MAX_LENGTH_OF_ISI = 100;
    const MAX_LENGTH_OF_PROSES = 100;
    const MAX_LENGTH_OF_KOMPETENSI_KELULUSAN = 100;
    const MAX_LENGTH_OF_PENDIDIKAN_DAN_TENAGA_KEPENDIDIKAN = 100;
    const MAX_LENGTH_OF_SARANA_PRASARANA = 100;
    const MAX_LENGTH_OF_PENGELOLAAN = 100;
    const MAX_LENGTH_OF_PEMBIAYAAN = 100;
    const MAX_LENGTH_OF_PENILAIAN_PENDIDIKAN = 100;
    const MAX_LENGTH_OF_FILE = 100;

    protected static function booted()
    {
        static::deleting(function ($environment) {
            if ((count($environment->studies) > 0)) {
                return false;
            } else {
                return true;
            }
        });

        static::deleted(function ($environment) {
            $environment->clearMediaCollection();
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

    public function studies()
    {
        return $this->hasMany(Study::class, 'environment_id', 'id');
    }

    public function school_profile()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_profile_id');
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file')->last();
    }
}
