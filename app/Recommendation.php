<?php

namespace App;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use Auditable;
    public $table = 'recommendations';

    protected $appends = [
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'cadre_activity_id',
        'recommendation',
        'pending',
        'continue',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted()
    {

    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function cadre_activity()
    {
        return $this->belongsTo(CadreActivity::class, 'cadre_activity_id');
    }
}
