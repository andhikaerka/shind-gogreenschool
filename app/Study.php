<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Study extends Model
{
    use Auditable;
    use Activable;

    public $table = 'studies';

    protected $appends = [
        'activities',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /*const PERIOD_SELECT = [
        '6' => '6 Bulan',
        '12' => '12 Bulan',
        '18' => '18 Bulan',
        '24' => '24 Bulan',
        '30' => '30 Bulan',
        '36' => '36 Bulan',
        '42' => '42 Bulan',
        '48' => '48 Bulan',
    ];*/

    protected $fillable = [
        //'quality_report_id',
        'self_development',
        'environment_id',
        'environmental_issue_id',
        'work_group_id',
        'snp_category_id',
        'potential',
        'problem',
        'activity',
        'behavioral',
        'physical',
        //'kbm',
        'artwork',
        'period',
        'lesson_plan_id',
        'budget_plan_id',
        'source',
        //'cost',
        'partner_id',
        'percentage',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const LIST_OF_SELF_DEVELOPMENT = ['Ekstakurikuler', 'Pembiasaan Diri'];
    const MAX_LENGTH_OF_POTENTIAL = 100;
    const MAX_LENGTH_OF_PROBLEM = 100;
    const MAX_LENGTH_OF_ACTIVITY = 100;
    const MAX_LENGTH_OF_BEHAVIORAL = 100;
    const MAX_LENGTH_OF_PHYSICAL = 100;
    const MAX_LENGTH_OF_KBM = 100;
    const MAX_LENGTH_OF_ARTWORK = 100;
    const MIN_PERIOD = 1;
    const MAX_PERIOD = 48;
    const MIN_PERCENTAGE = 1;
    const MAX_PERCENTAGE = 100;

    const SOURCE_SELECT = [
        'BOS' => 'BOS',
        'BOS NAS' => 'BOS NAS',
        'BOSDA' => 'BOSDA',
        'Komite' => 'Komite',
        'Sponsor' => 'Sponsor',
    ];

    protected static function booted()
    {
        static::deleting(function ($study) {
            foreach ($study->studyWorkPrograms as $workProgram) {
                $workProgram->delete();
            }
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function studyWorkPrograms()
    {
        return $this->hasMany(WorkProgram::class, 'study_id', 'id');
    }

    public function quality_report()
    {
        return $this->belongsTo(QualityReport::class, 'quality_report_id');
    }

    public function environment()
    {
        return $this->belongsTo(Environment::class, 'environment_id');
    }

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function snp_category()
    {
        return $this->belongsTo(SnpCategory::class, 'snp_category_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function checklist_templates()
    {
        return $this->belongsToMany(ChecklistTemplate::class);
    }

    public function team_statuses()
    {
        return $this->belongsToMany(TeamStatus::class);
    }

    public function environmentalIssue()
    {
        return $this->belongsTo(EnvironmentalIssue::class, 'environmental_issue_id');
    }

    public function lessonPlan()
    {
        return $this->belongsTo(LessonPlan::class, 'lesson_plan_id');
    }

    public function budgetPlan()
    {
        return $this->belongsTo(BudgetPlan::class, 'budget_plan_id');
    }

    public function getActivitiesAttribute()
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
    }
}
