<?php

namespace App;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Province extends Model
{
    use Auditable;
    public $table = 'provinces';

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
    ];

    protected static function booted()
    {
        static::deleting(function ($province) {
            if ((count($province->provinceCities) > 0)) {
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

    public function provinceCities()
    {
        return $this->hasMany(City::class, 'province_id', 'id');

    }
}
