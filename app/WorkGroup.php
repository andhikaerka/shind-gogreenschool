<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class WorkGroup extends Model
{
    use Auditable;
    use Activable;

    const MAX_LENGTH_OF_DESCRIPTION = 50;
    const MAX_LENGTH_OF_TUTOR = 35;
    const MAX_LENGTH_OF_TASK = 100;

    public $table = 'work_groups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_profile_id',
        'work_group_name_id',
        'alias',
        'description',
        // 'user_id',
        'aspect_id',
        'tutor',
        'task',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted()
    {
        static::deleting(function ($workGroup) {
            foreach ($workGroup->workGroupInfrastructures as $infrastructure) {
                $infrastructure->delete();
            }
            foreach ($workGroup->workGroupCadres as $cadre) {
                $cadre->delete();
            }
            foreach ($workGroup->workGroupStudies as $study) {
                $study->delete();
            }
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function workGroupInfrastructures()
    {
        return $this->hasMany(Infrastructure::class, 'work_group_id', 'id');
    }

    public function workGroupTeams()
    {
        return $this->hasMany(Team::class, 'work_group_id', 'id');
    }

    public function workGroupCadres()
    {
        return $this->hasMany(Cadre::class, 'work_group_id', 'id');
    }

    public function workGroupStudies()
    {
        return $this->hasMany(Study::class, 'work_group_id', 'id');
    }

    public function workGroupInnovations()
    {
        return $this->hasMany(Innovation::class, 'work_group_id', 'id');
    }

    public function workGroupActivities()
    {
        return $this->hasMany(Activity::class, 'work_group_id', 'id');
    }

    public function workGroupMonitors()
    {
        return $this->hasMany(Monitor::class, 'work_group_id', 'id');
    }

    public function school_profile()
    {
        return $this->belongsTo(SchoolProfile::class, 'school_profile_id');
    }

    /*public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }*/

    public function work_group_name()
    {
        return $this->belongsTo(WorkGroupName::class, 'work_group_name_id');
    }

    public function aspect()
    {
        return $this->belongsTo(Aspect::class, 'aspect_id');
    }
}
