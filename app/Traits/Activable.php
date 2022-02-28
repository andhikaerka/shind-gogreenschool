<?php

namespace App\Traits;

use App\School;
use Illuminate\Database\Eloquent\Model;

trait Activable
{
    public static function bootActivable()
    {
        static::created(function (Model $model) {
            self::activa();
        });

        static::updated(function (Model $model) {
            self::activa();
        });

        static::deleted(function (Model $model) {
            self::activa();
        });
    }

    protected static function activa()
    {
        if (auth()->check() && auth()->user()->isSTC) {
            School::query()
                ->where('id', '=', auth()->user()->isSTC)
                ->update(['updated_at' => date('Y-m-d H:i:s')]);
        }

    }
}
