<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

class WorkProgram extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia, Activable;

    public $table = 'work_programs';

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
        'study_id',
        'condition',
        'plan',
        // 'activity',
        'percentage',
        'time',
        'tutor_1',
        'tutor_2',
        'tutor_3',
        'featured',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const MAX_LENGTH_OF_CONDITION = 100;
    const MAX_LENGTH_OF_PLAN = 100;
    const MIN_TIME = 1;
    const MAX_TIME = 12;
    const MIN_PERCENTAGE = 1;
    const MAX_PERCENTAGE = 100;

    protected static function booted()
    {
        static::deleting(function ($workProgram) {
            foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                $cadreActivity->delete();
            }
        });

        static::deleted(function ($workProgram) {
            $workProgram->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function study()
    {
        return $this->belongsTo(Study::class, 'study_id');
    }

    /*public function checklist_templates()
    {
        return $this->belongsToMany(ChecklistTemplate::class);
    }*/

    public function workProgramCadreActivities()
    {
        return $this->hasMany(CadreActivity::class, 'work_program_id', 'id');
    }

    public function getPhotoAttribute()
    {
        return $this->getMedia('photo')->last();
    }

    public function getTutorAttribute()
    {
        $tutor = $this->attributes['tutor_1'] ? $this->attributes['tutor_1'] : "";

        $tutor .= $this->attributes['tutor_2'] ? ',<br>' . $this->attributes['tutor_2'] : "";

        $tutor .= $this->attributes['tutor_3'] ? ',<br>' . $this->attributes['tutor_3'] : "";

        return $tutor;
    }

    /*public function getActivitiesAttribute()
    {
        $activities = '<ol style="padding-inline-start: 20px;">';

        foreach ($this->checklist_templates()->get() as $checklist_template) {
            $activities .= '<li>';
            if ($checklist_template->parent_checklist_template) {
                $activities .= $checklist_template->parent_checklist_template->name . ': ' . $checklist_template->text;
            } else {
                $activities .= $checklist_template->text;
            }
            $activities .= '</li>';
        }

        if ($this->attributes['activity']) {
            $activities .= '<li>';
            $activities .= $this->attributes['activity'];
            $activities .= '</li>';
        }

        $activities .= '</ol>';

        return $activities;
    }*/
}
