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

class Team extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia, Activable;

    public $table = 'teams';

    protected $appends = [
        'document',
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

    protected $fillable = [
        'user_id',
        'name',
        'team_status_id',
        'gender',
        'birth_date',
        'work_group_id',
        'job_description',
        'team_position_id',
        'another_position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_NAME = 50;
    const MAX_LENGTH_OF_JOB_DESCRIPTION = 100;

    protected static function booted()
    {
        static::deleted(function ($team) {
            $team->clearMediaCollection();

            User::query()->find($team['user_id'])->delete();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function team_status()
    {
        return $this->belongsTo(TeamStatus::class, 'team_status_id');
    }

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function team_position()
    {
        return $this->belongsTo(TeamPosition::class, 'team_position_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getBirthDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }
}
