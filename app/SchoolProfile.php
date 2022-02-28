<?php

namespace App;

use App\Traits\Activable;
use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SchoolProfile extends Model implements HasMedia
{
    use Auditable;
    use InteractsWithMedia;
    use Activable;

    const MAX_LENGTH_OF_VISION = 200;

    public $table = 'school_profiles';

    protected $appends = [
        'photo',
        'score',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'school_id',
        'year',
        'environmental_status_id',
        'vision',
        'total_teachers',
        'total_students',
        'total_land_area',
        'total_building_area',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    protected static function booted()
    {
        static::deleted(function ($school_profile) {
            $school_profile->clearMediaCollection();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getPhotoAttribute()
    {
        return $this->getMedia('photo')->last();
    }

    public function getScoreAttribute()
    {
        return
            ($this->work_groups_score['score'] ?? 0) + //2
            ($this->school_profile_score['score'] ?? 0) + //3
            ($this->infrastructures_score['score'] ?? 0) + //4
            ($this->disasters_score['score'] ?? 0) + //5
            ($this->quality_reports_score['score'] ?? 0) + //6
            ($this->teams_score['score'] ?? 0) + //7
            ($this->studies_score['score'] ?? 0) + //8
            ($this->curricula_score['score'] ?? 0) + //9
            ($this->lesson_plans_score['score'] ?? 0) + //10
            ($this->budget_plans_score['score'] ?? 0) + //11
            ($this->partners_score['score'] ?? 0) + //12
            ($this->cadres_score['score'] ?? 0) + //13
            ($this->work_programs_score['score'] ?? 0) + //14

            ($this->cadre_activities_score['score'] ?? 0) + //a
            ($this->activities_score['score'] ?? 0) + //b
            ($this->monitors_score['score'] ?? 0) + //c
            ($this->evaluations_score['score'] ?? 0) + //d
            ($this->recommendations_score['score'] ?? 0) + //rekomendasi
            ($this->assessments_score['score'] ?? 0); //penilaian akhir
    }

    /* 3 Profil Sekolah */
    public function getSchoolProfileScoreAttribute()
    {
        $vision = stripos(strtolower($this->attributes['vision']), 'lingkungan') !== false;
        $difference = 0;
        if ($this->attributes['total_land_area'] > 0 && $this->attributes['total_building_area']) {
            $difference = ($this->attributes['total_land_area'] - $this->attributes['total_building_area']) / $this->attributes['total_land_area'] * 100;
        }

        if ($vision && $difference >= 30) {
            $score = 3;
            $condition = 'Baik';
        } elseif ($vision) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['score' => $score, 'condition' => $condition];
    }

    /* 2 Nama Pokja */
    public function getWorkGroupsScoreAttribute()
    {
        $workGroupsCount = $this->schoolProfileWorkGroups()->get()->count();

        if ($workGroupsCount >= 10) {
            $score = 3;
            $condition = 'Baik';
        } elseif ($workGroupsCount >= 5) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $workGroupsCount, 'score' => $score, 'condition' => $condition];
    }

    /* 4 Sarpras */
    public function getInfrastructuresScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()->get();
        $infrastructuresCount = 0;

        foreach ($workGroups as $workGroup) {
            $infrastructuresCount += count($workGroup->workGroupInfrastructures ?? []);
        }

        if ($infrastructuresCount > 7) {
            $score = 3;
            $condition = 'Baik';
        } elseif ($infrastructuresCount > 3) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $infrastructuresCount, 'score' => $score, 'condition' => $condition];
    }

    /* 5 Kebencanaan */
    public function getDisastersScoreAttribute()
    {
        $disastersCount = $this->schoolProfileDisasters()->get()->count();

        if ($disastersCount <= 2) {
            $score = 2;
            $condition = 'Baik';
        } elseif ($disastersCount > 2) {
            $score = 1;
            $condition = 'Sedang';
        } else {
            $score = 0;
            $condition = 'Kurang';
        }

        return ['total' => $disastersCount, 'score' => $score, 'condition' => $condition];
    }

    /* 6 Rapor Mutu */
    public function getQualityReportsScoreAttribute()
    {
        $qualityReportsCount = $this->schoolProfileQualityReports()->get()->count();

        if ($qualityReportsCount >= 1) {
            $score = 1;
            $condition = 'Baik';
        } else {
            $score = 0;
            $condition = 'Kurang';
        }

        return ['total' => $qualityReportsCount, 'score' => $score, 'condition' => $condition];
    }

    /* 6 Isu Lingkungan */
    public function getEnvironmentalIssueScoreAttribute()
    {
        $lokal = $this->schoolProfileEnvironmentalIssues()->where('category', 'Lokal')->count();
        $perfect = false;
        $total = $lokal;
        if($lokal){
            $global = $this->schoolProfileEnvironmentalIssues()->where('category', 'Global')->count();
            $total += $lokal;
            if($global){
                $nasional = $this->schoolProfileEnvironmentalIssues()->where('category', 'Nasional')->count();
                $total += $global;
                if($nasional){
                    $daerah = $this->schoolProfileEnvironmentalIssues()->where('category', 'Daerah')->count();
                    $total += $nasional;
                    if($daerah){
                        $perfect = true;
                        $total += $daerah;
                    }
                }
            }
        }

        if ($perfect) {
            $score = 2;
            $condition = 'Baik';
        } else {
            $score = 1;
            $condition = 'Sedang';
        }

        return ['total' => $total, 'score' => $score, 'condition' => $condition];
    }

    /* 6 Ekstrakurikuler */
    public function getExtracurricularScoreAttribute()
    {
        $extracurricularCount = $this->schoolProfileExtracurriculars()->get()->count();

        if ($extracurricularCount >= 1) {
            $score = 1;
            $condition = 'Baik';
        } else {
            $score = 0;
            $condition = 'Kurang';
        }

        return ['total' => $extracurricularCount, 'score' => $score, 'condition' => $condition];
    }

    /* 6 Pembiasaan */
    public function getHabituationScoreAttribute()
    {
        $habituationCount = $this->schoolProfileHabituations()->get()->count();

        if ($habituationCount >= 1) {
            $score = 1;
            $condition = 'Baik';
        } else {
            $score = 0;
            $condition = 'Kurang';
        }

        return ['total' => $habituationCount, 'score' => $score, 'condition' => $condition];
    }

    /* 6 pengembangan */
    public function getSelfDevelopmentScoreAttribute()
    {
        $extracurricularCount = $this->schoolProfileExtracurriculars()->get()->count();
        $habituationCount = $this->schoolProfileHabituations()->get()->count();
        $selfDevelopmentCount = $extracurricularCount + $habituationCount;

        if ($selfDevelopmentCount >= 5) {
            $score = 2;
            $condition = 'Baik';
        } else {
            $score = 1;
            $condition = 'Sedang';
        }

        return ['total' => $habituationCount, 'score' => $score, 'condition' => $condition];
    }

    /* 7 Tim Sekolah */
    public function getTeamsScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()->get();
        $teamsCount = 0;

        foreach ($workGroups as $workGroup) {
            $teamsCount += count($workGroup->workGroupTeams ?? []);
        }

        if ($this->attributes['total_teachers'] > 0) {
            $n = $teamsCount / $this->attributes['total_teachers'] * 100;
        } else {
            $n = 0;
        }

        if ($n >= 70) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($n >= 50) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($n >= 20) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $n, 'score' => $score, 'condition' => $condition];
    }

    /* 8 IPMLH */
    public function getStudiesScoreAttribute()
    {
        $workGroupsGroupByAspectCount = $this->schoolProfileWorkGroups()
            ->select('aspect_id')
            ->groupBy('aspect_id')
            ->has('workGroupStudies')
            ->get()
            ->count();

        if ($workGroupsGroupByAspectCount >= 4) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($workGroupsGroupByAspectCount >= 3) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($workGroupsGroupByAspectCount >= 2) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $workGroupsGroupByAspectCount, 'score' => $score, 'condition' => $condition];
    }

    /* 9 KTSP */
    public function getCurriculaScoreAttribute()
    {
        $visionCount = $this->schoolProfileCurricula()
            ->where('vision', 'like', '%lingkungan%')
            ->get()
            ->count();
        $calendarsCount = $this->schoolProfileCurricula()
            ->has('calendars')
            ->get()
            ->count();

        if ($visionCount && $calendarsCount) {
            $score = 2;
            $condition = 'Baik';
        } elseif ($visionCount) {
            $score = 1;
            $condition = 'Sedang';
        } else {
            $score = 0;
            $condition = 'Kurang';
        }

        return ['total' => $calendarsCount, 'score' => $score, 'condition' => $condition];
    }

    /* 10 Silabus RPP */
    public function getLessonPlansScoreAttribute()
    {
        $lessonPlansCount = $this->schoolProfileLessonPlans()
            ->get()
            ->count();

        if ($lessonPlansCount >= 30) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($lessonPlansCount >= 20) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($lessonPlansCount >= 15) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $lessonPlansCount, 'score' => $score, 'condition' => $condition];
    }

    /* 11 RAKS */
    public function getBudgetPlansScoreAttribute()
    {
        $budgetPlansGroupByAspectCount = $this->schoolProfileBudgetPlans()
            ->select('aspect_id')
            ->groupBy('aspect_id')
            ->get()
            ->count();
        $budgetPlansGroupByCategoryCount = $this->schoolProfileBudgetPlans()
            ->select('snp_category_id')
            ->groupBy('snp_category_id')
            ->get()
            ->count();

        if ($budgetPlansGroupByAspectCount >= 5) {
            $score = 3;
            $condition = 'Baik';
        } elseif ($budgetPlansGroupByAspectCount >= 4) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $budgetPlansGroupByAspectCount + $budgetPlansGroupByCategoryCount, 'score' => $score, 'condition' => $condition];
    }

    /* 12 Kemitraan */
    public function getPartnersScoreAttribute()
    {
        $partnersCount = $this->schoolProfilePartners()
            ->get()
            ->count();

        if ($partnersCount >= 7) {
            $score = 3;
            $condition = 'Baik';
        } elseif ($partnersCount >= 4) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $partnersCount, 'score' => $score, 'condition' => $condition];
    }

    /* 13 */
    public function getCadresCountAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        $cadresCount = 0;

        foreach ($workGroups as $workGroup) {
            $cadresCount += count($workGroup->workGroupCadres ?? []);
        }

        return $cadresCount;
    }

    /* 13 Kader */
    public function getCadresScoreAttribute()
    {
        $cadresCount = $this->getCadresCountAttribute();

        if ($this->attributes['total_students'] > 0) {
            $n = $cadresCount / $this->attributes['total_students'] * 100;
        } else {
            $n = 0;
        }

        if ($n >= 20) {
            $score = 5;
            $condition = 'Baik Sekali';
        } elseif ($n >= 15) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($n >= 10) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($n >= 5) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $n, 'score' => $score, 'condition' => $condition];
    }

    /* 14 Proker Kader */
    public function getWorkProgramsScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        $workProgramsCount = 0;

        foreach ($workGroups as $workGroup) {
                foreach ($workGroup->workGroupStudies as $study) {
                    $workProgramsCount += count($study->studyWorkPrograms ?? []);
                }
        }

        if ($workProgramsCount > 40) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($workProgramsCount > 30) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($workProgramsCount > 20) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $workProgramsCount, 'score' => $score, 'condition' => $condition];
    }

    /* 15 */
    public function getInnovationsScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        $innovationsCount = 0;

        foreach ($workGroups as $workGroup) {
            $innovationsCount += count($workGroup->workGroupInnovations ?? []);
        }

        if ($innovationsCount >= 3) {
            $score = 3;
            $condition = 'Baik';
        } elseif ($innovationsCount >= 2) {
            $score = 2;
            $condition = 'Sedang';
        } elseif ($innovationsCount >= 1) {
            $score = 1;
            $condition = 'Kurang';
        } else {
            $score = 0;
            $condition = 'Kurang';
        }

        return ['total' => $innovationsCount, 'score' => $score, 'condition' => $condition];
    }

    /* A Pelaksanaan Kegiatan Kader */
    public function getCadreActivitiesScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        $cadreActivitiesCount = 0;
        $cadreActivitiesPercentageCount = 0;

        foreach ($workGroups as $workGroup) {
            foreach ($workGroup->workGroupStudies as $study) {
                foreach ($study->studyWorkPrograms as $workProgram) {
                    foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                        $cadreActivitiesCount += 1;
                        $cadreActivitiesPercentageCount += $cadreActivity->percentage;
                    }
                }
            }
        }

        if ($cadreActivitiesCount > 0) {
            $percentage = $cadreActivitiesPercentageCount / $cadreActivitiesCount;
        } else {
            $percentage = 0;
        }

        if ($percentage >= 90) {
            $score = 10;
            $condition = 'Baik Sekali';
        } elseif ($percentage >= 80) {
            $score = 9;
            $condition = 'Baik';
        } elseif ($percentage >= 60) {
            $score = 7;
            $condition = 'Cukup';
        } elseif ($percentage >= 30) {
            $score = 5;
            $condition = 'Sedang';
        } elseif ($percentage > 0) {
            $score = 3;
            $condition = 'Kurang';
        } else {
            $score = 0;
            $condition = 'Kurang';
        }

        return ['total' => $percentage, 'score' => $score, 'condition' => $condition];
    }

    /* B Kegiatan Baru */
    public function getActivitiesScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        $activitiesCount = 0;

        foreach ($workGroups as $workGroup) {
            $activitiesCount += count($workGroup->workGroupActivities ?? []);
        }

        if ($activitiesCount > 7) {
            $score = 3;
            $condition = 'Baik';
        } elseif ($activitiesCount > 3) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $activitiesCount, 'score' => $score, 'condition' => $condition];
    }

    /* C Monitoring */
    public function getMonitorsScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        $monitorsCount = 0;

        foreach ($workGroups as $workGroup) {
            $monitorsCount += count($workGroup->workGroupMonitors ?? []);
        }

        if ($monitorsCount >= 3) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($monitorsCount >= 3) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($monitorsCount >= 2) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $monitorsCount, 'score' => $score, 'condition' => $condition];
    }

    /* D perencanaan */
    public function getPlanningScoreAttribute()
    {
        $score =
            ($this->teams_score['score'] ?? 0) + //7
            ($this->work_groups_score['score'] ?? 0) + //2
            ($this->school_profile_score['score'] ?? 0) + //3
            ($this->infrastructures_score['score'] ?? 0) + //4
            ($this->disasters_score['score'] ?? 0) + //5

            ($this->environmental_issue_score['score'] ?? 0) + //5

            ($this->quality_reports_score['score'] ?? 0) + //6 eds LH
            ($this->curricula_score['score'] ?? 0) + //9
            ($this->lesson_plans_score['score'] ?? 0) + //10

            ($this->extracurricular_score['score'] ?? 0) + //5
            ($this->habituation_score['score'] ?? 0) + //5

            ($this->budget_plans_score['score'] ?? 0) + //11
            ($this->partners_score['score'] ?? 0) + //12
            ($this->cadres_score['score'] ?? 0) + //13
            ($this->studies_score['score'] ?? 0) + //8
            ($this->work_programs_score['score'] ?? 0) + //14
            ($this->innovations_score['score'] ?? 0);  //14

        return $score;
    }

    /* D pelaksanaan */
    public function getImplementationScoreAttribute()
    {
        $score =
        ($this->cadre_activities_score['score'] ?? 0) + //7
        ($this->activities_score['score'] ?? 0);//2
        return $score;
    }

    /* D monev*/
    public function getMonevScoreAttribute()
    {
        $score =
        ($this->monitors_score['score'] ?? 0) + //7
        ($this->evaluations_score['score'] ?? 0) + //7
        ($this->recommendations_score['score'] ?? 0);//2
        return $score;
    }

    /* D Evaluasi */
    public function getEvaluationsScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        /*$checklistTemplateIds = [];

        foreach ($workGroups as $workGroup) {
            if ($workGroup && $workGroup->work_group_studies) {
                foreach ($workGroup->work_group_studies as $study) {
                    if ($study['activity'] && !in_array($study['activity'], $checklistTemplateIds)) {
                        array_push($study['activity'], $checklistTemplateIds);
                    }
                    foreach ($study->checklist_templates as $checklist_template) {
                        if (!in_array($checklist_template['checklist_template_id'], $checklistTemplateIds)) {
                            array_push($checklist_template['checklist_template_id'], $checklistTemplateIds);
                        }
                    }
                }
            }
        }*/
        $cadreActivitiesCount = 0;
        $cadreActivitiesPercentageCount = 0;

        foreach ($workGroups as $workGroup) {
            foreach ($workGroup->workGroupStudies as $study) {
                foreach ($study->studyWorkPrograms as $workProgram) {
                    foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                        $cadreActivitiesCount += 1;
                        $cadreActivitiesPercentageCount += $cadreActivity->percentage;
                    }
                }
            }
        }

        if ($cadreActivitiesCount > 0) {
            $percentage = $cadreActivitiesPercentageCount / $cadreActivitiesCount;
        } else {
            $percentage = 0;
        }

        if ($percentage >= 90) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($percentage >= 70) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($percentage >= 50) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $percentage, 'score' => $score, 'condition' => $condition];
    }

    /* E Rekomendasi / Rencana Tindak Lanjut */
    public function getRecommendationsScoreAttribute()
    {
        $workGroups = $this->schoolProfileWorkGroups()
            ->get();
        $recommendationsCount = 0;

        foreach ($workGroups as $workGroup) {
            if ($workGroup && $workGroup->work_group_studies) {
                foreach ($workGroup->work_group_studies as $study) {
                    foreach ($study->studyWorkPrograms as $workProgram) {
                        foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                            foreach ($cadreActivity->cadreActivityRecommendations as $recommendation) {
                                if ($recommendation->continue > 0) {
                                    $recommendationsCount++;
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($recommendationsCount >= 20) {
            $score = 4;
            $condition = 'Baik';
        } elseif ($recommendationsCount >= 10) {
            $score = 3;
            $condition = 'Cukup';
        } elseif ($recommendationsCount >= 5) {
            $score = 2;
            $condition = 'Sedang';
        } else {
            $score = 1;
            $condition = 'Kurang';
        }

        return ['total' => $recommendationsCount, 'score' => $score, 'condition' => $condition];
    }

    /* 21 Penilaian Akhir */
    public function getAssessmentsScoreAttribute()
    {
        $assessment = $this->schoolProfileAssessment()->first();
        $assessmentScore = $assessment ? (int)$assessment->score : 0;

        if ($assessmentScore >= 95) {
            $score = 30;
            $condition = 'Baik Sekali';
        } elseif ($assessmentScore >= 81) {
            $score = 25;
            $condition = 'Baik';
        } elseif ($assessmentScore >= 71) {
            $score = 20;
            $condition = 'Cukup';
        } elseif ($assessmentScore >= 51) {
            $score = 10;
            $condition = 'Sedang';
        } else {
            $score = 5;
            $condition = 'Kurang';
        }

        return ['total' => $assessmentScore, 'score' => $score, 'condition' => $condition];
    }

    public function getStudiesPercentageAttribute()
    {
        return Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) {
                $builder->where('id', $this->attributes['id']);
            })
            ->sum('percentage');
    }

    public function getActionPlanPercentageAttribute()
    {
        $percentage = 0;

        // Komposting
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 5 : 10;
        // Bank Sampah
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 5 : 10;
        // Daur Ulang
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 5 : 10;

        // Hemat Energi
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 5 : 10;
        // Energi Terbarukan
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 2.5 : 5;
        // Engine Off
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 2.5 : 5;

        // Taman
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 5 : 10;
        // Toga
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 2.5 : 5;
        // Greenhouse
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 2.5 : 5;

        // Drainase Sekolah
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 5 : 10;
        // Sanitasi Lingkungan
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 2.5 : 5;

        // Sumur Resapan
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 1 : 2.5;
        // Biopori
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 1 : 2.5;

        // Reduce Plastik
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 2.5 : 5;
        // Sampah Kantin
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 1 : 3;
        // Kantin Aman
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 0.5 : 1;
        // Kantin Bergizi
        $percentage += (Activity::query()->whereHas('work_group', function (Builder $builder) {
                $builder->where('work_group_name_id', '=', 1);
            })->count() < 5) ? 0.5 : 1;

        return $percentage;
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function environmental_status()
    {
        return $this->belongsTo(EnvironmentalStatus::class, 'environmental_status_id');
    }

    public function schoolProfileWorkGroups()
    {
        return $this->hasMany(WorkGroup::class, 'school_profile_id', 'id');
    }

    public function schoolProfileDisasters()
    {
        return $this->hasMany(Disaster::class, 'school_profile_id', 'id');
    }

    public function schoolProfileQualityReports()
    {
        return $this->hasMany(QualityReport::class, 'school_profile_id', 'id');
    }

    public function schoolProfileEnvironments()
    {
        return $this->hasMany(Environment::class, 'school_profile_id', 'id');
    }

    public function schoolProfileEnvironmentalIssues()
    {
        return $this->hasMany(EnvironmentalIssue::class, 'school_profile_id', 'id');
    }

    public function schoolProfileExtracurriculars()
    {
        return $this->hasMany(Extracurricular::class, 'school_profile_id', 'id');
    }

    public function schoolProfileHabituations()
    {
        return $this->hasMany(Habituation::class, 'school_profile_id', 'id');
    }

    public function schoolProfileCurricula()
    {
        return $this->hasMany(Curriculum::class, 'school_profile_id', 'id');
    }

    public function schoolProfileLessonPlans()
    {
        return $this->hasMany(LessonPlan::class, 'school_profile_id', 'id');
    }

    public function schoolProfileBudgetPlans()
    {
        return $this->hasMany(BudgetPlan::class, 'school_profile_id', 'id');
    }

    public function schoolProfilePartners()
    {
        return $this->hasMany(Partner::class, 'school_profile_id', 'id');
    }

    public function schoolProfileAssessment()
    {
        return $this->hasOne(Assessment::class, 'school_profile_id', 'id');
    }
}
