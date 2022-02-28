<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CadreActivity extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    public $table = 'cadre_activities';

    protected $appends = [
        'document',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'date',
        'self_development',
        'work_program_id',
        'condition',
        'percentage',
        'results',
        'problem',
        'behavioral',
        'physical',
        'plan',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const LIST_OF_SELF_DEVELOPMENT = ['Ekstakurikuler', 'Pembiasaan Diri'];
    const MAX_LENGTH_OF_RESULTS = 100;
    const MAX_LENGTH_OF_PROBLEM = 100;
    const MAX_LENGTH_OF_BEHAVIORAL = 100;
    const MAX_LENGTH_OF_PHYSICAL = 100;
    const MAX_LENGTH_OF_PLAN = 100;
    const MIN_PERCENTAGE = 1;
    const MAX_PERCENTAGE = 100;

    const CONDITION_SELECT = [
        1 => 'Mulai dikerjakan (10%)',
        2 => 'Sedang berproses (25%)',
        3 => 'Setengah target (30%)',
        4 => 'Mununjukkan hasil (25%)',
        5 => 'Melengkapi dokumen (10%)',
    ];

    const PERCENTAGE_SELECT = [
        1 => 10,
        2 => 25,
        3 => 30,
        4 => 25,
        5 => 10,
    ];

    protected static function booted()
    {
        static::deleted(function ($cadreActivity) {
            $cadreActivity->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function getDocumentAttribute()
    {
        return $this->getMedia('document')->last();
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function work_program()
    {
        return $this->belongsTo(WorkProgram::class, 'work_program_id');
    }

    public function team_statuses()
    {
        return $this->belongsToMany(TeamStatus::class);
    }

    public function cadreActivityRecommendations()
    {
        return $this->hasMany(Recommendation::class, 'cadre_activity_id', 'id');
    }
}
