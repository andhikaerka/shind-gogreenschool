<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class ActivityImplementation extends Model
{
    use Auditable;
    use Activable;

    public $table = 'activity_implementations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const PROGRESS_SELECT = [
        '10' => 'Mulai Dikerjakan (10%)',
        '25' => 'Sedang Berproses (25%)',
        '50' => 'Setengah Target (50%)',
        '75' => 'Menunjukkan Hasil (75%)',
        '100' => 'Selesai Lengkap Dok. (100%)',
    ];

    protected $fillable = [
        'date',
        'work_group_id',
        'activity_id',
        'progress',
        'constraints',
        'plan',
        'document',
        'created_at',
        'updated_at',
        'deleted_at',
    ];



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
