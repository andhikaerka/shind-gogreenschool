<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use \DateTimeInterface;

class Innovation extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'innovations';

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
        'work_group_id',
        'activity',
        'tutor',
        'purpose',
        'advantage',
        'innovation',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_NAME = 50;
    const MAX_LENGTH_OF_ACTIVITY = 100;
    const MAX_LENGTH_OF_TUTOR = 100;
    const MAX_LENGTH_OF_PURPOSE = 100;
    const MAX_LENGTH_OF_ADVANTAGE = 100;
    const MAX_LENGTH_OF_INNOVATION = 100;

    const PARTIES_INVOLVED_SELECT = [
        'Kepala Sekolah' => 'Kepala Sekolah',
        'Komite Sekolah' => 'Komite Sekolah',
        'Guru/Staf' => 'Guru/Staf',
        'Siswa' => 'Siswa',
        'Kader Adiwiyata' => 'Adiwiyata',
        'Tokoh Masyarakat' => 'Tokoh Masyarakat',
        'Petugas Kebersihan' => 'Petugas Kebersihan',
        'Petugas Keamanan' => 'Petugas Keamanan',
        'Penjaga Sekolah' => 'Penjaga Sekolah',
        'Orang tua / Paguyuban' => 'Orang tua / Paguyuban',
        'Pihak Mitra lainnya' => 'Pihak Mitra lainnya',
    ];

    protected static function booted()
    {
        static::deleted(function ($innovation) {
            $innovation->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function team_statuses()
    {
        return $this->belongsToMany(TeamStatus::class);
    }

    public function getPhotoAttribute()
    {
        return $this->getMedia('photo')->last();
    }
}
