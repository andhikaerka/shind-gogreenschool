<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class City extends Model
{
    use Auditable;

    public $table = 'cities';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
        'province_id',
    ];

    protected static function booted()
    {
        static::deleting(function ($city) {
            if ((count($city->citySchools) > 0)) {
                return false;
            } else {
                return true;
            }
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }

    public function citySchools()
    {
        return $this->hasMany(School::class, 'city_id', 'id');

    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');

    }
}
