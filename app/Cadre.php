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

class Cadre extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'cadres';

    protected $appends = [
        'photo',
        'letter',
    ];

    const GENDER_SELECT = [
        '1' => 'Laki-laki',
        '2' => 'Perempuan',
    ];

    protected $dates = [
        'birth_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const POSITION_SELECT = [
        'Ketua' => 'Ketua',
        'Wakil' => 'Wakil',
        'Sekretaris' => 'Sekretaris',
        'Bendahara' => 'Bendahara',
        'Anggota' => 'Anggota',
    ];

    protected $fillable = [
        'user_id',
        'work_group_id',
        'gender',
        'birth_date',
        'phone',
        'class',
        'address',
        'hobby',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_NAME = 50;
    const MAX_LENGTH_OF_ADDRESS = 100;
    const MAX_LENGTH_OF_HOBBY = 100;

    const CLASS_SELECT = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
    ];

    protected static function booted()
    {
        static::deleted(function ($cadre) {
            $cadre->clearMediaCollection();

            User::query()->find($cadre['user_id'])->delete();
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function getAgeAttribute()
    {
        return $this->attributes['birth_date'] ? Carbon::parse($this->attributes['birth_date'])->age : null;
    }

    public function getBirthDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();

        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getLetterAttribute()
    {
        return $this->getMedia('letter')->last();
    }
}
