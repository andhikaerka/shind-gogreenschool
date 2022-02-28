<?php

namespace App\Http\Requests;

use App\Study;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateStudyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('study_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        $maxPercentage = Study::MAX_PERCENTAGE;
        $percentageAmountNow = Study::query()
            /*->whereHas('quality_report.school_profile.school', function (Builder $builder) {
               $builder->where('slug', auth()->user()->school_slug);
           })*/
            ->whereHas('work_group.school_profile.school', function (Builder $builder) {
                $builder->where('slug', auth()->user()->school_slug);
            })
            ->whereHas('work_group.school_profile', function (Builder $builder) {
                $builder->where('year', $this->study->work_group->school_profile->year);
            })
            /*->whereHas('partner.school_profile.school', function (Builder $builder) {
                $builder->where('slug', auth()->user()->school_slug);
            })*/
            ->whereHas('work_group', function (Builder $builder) {
                $builder->where('aspect_id', request()->input('aspect_id'));
            })
            ->where('id', '!=', $this->study->id)
            ->sum('percentage');
        $maxPercentage = $maxPercentage - $percentageAmountNow;

        return [
            //'quality_report_id' => ['required', 'integer', 'exists:quality_reports,id'],
            'self_development' => ['required', 'string', 'in:'.join(',', Study::LIST_OF_SELF_DEVELOPMENT)],
            'environmental_issue_id' => ['required', 'exists:environmental_issues,id'],
            'environment_id' => ['required', 'integer', 'exists:environments,id'],
            'work_group_id' => ['required', 'integer', 'exists:work_groups,id'],
            'snp_category_id' => ['required', 'integer', 'exists:snp_categories,id'],
            'potential' => ['required', 'string'],
            'problem' => ['required', 'string', 'max:' . Study::MAX_LENGTH_OF_PROBLEM],
            'checklist_templates.*' => ['integer', 'exists:checklist_templates,id'],
            'checklist_templates' => ['nullable', 'array'],
            'activity' => ['nullable', 'string', 'max:' . Study::MAX_LENGTH_OF_ACTIVITY],
            'behavioral' => ['required', 'string', 'max:' . Study::MAX_LENGTH_OF_BEHAVIORAL],
            'physical' => ['required', 'string', 'max:' . Study::MAX_LENGTH_OF_PHYSICAL],
            //'kbm' => ['required', 'string', 'max:' . Study::MAX_LENGTH_OF_KBM],
            'artwork' => ['required', 'string', 'max:' . Study::MAX_LENGTH_OF_ARTWORK],
            'period' => ['required', 'integer', 'min:1', 'max:48'],
            'source' => ['required', 'string'],
            'partner_id' => ['required', 'integer', 'exists:partners,id'],
            'percentage' => ['required', 'integer', 'min:0', 'max:' . $maxPercentage],
            'team_statuses.*' => ['integer', 'exists:team_statuses,id'],
            'team_statuses' => ['required', 'array'],
            'lesson_plan_id' => ['required', 'integer', 'exists:lesson_plans,id'],
            'budget_plan_id' => ['required', 'integer', 'exists:budget_plans,id']
        ];

    }

    public function attributes()
    {
        return [
            'title' => strtolower(trans('crud.study.fields.title')),
            'self_development' => strtolower(trans('crud.study.fields.self_development')),
            'environment_id' => strtolower(trans('crud.study.fields.environment_id')),
            'environmental_issue_id' => strtolower(trans('crud.lessonPlan.fields.environmental_issue_id')),
            'quality_report_id' => strtolower(trans('crud.study.fields.quality_report')),
            'work_group_id' => strtolower(trans('crud.study.fields.work_group')),
            'potential' => strtolower(trans('crud.study.fields.potential')),
            'problem' => strtolower(trans('crud.study.fields.problem')),
            'checklist_templates.*' => strtolower(trans('crud.study.fields.checklist_templates')),
            'checklist_templates' => strtolower(trans('crud.study.fields.checklist_templates')),
            'activity' => strtolower(trans('crud.study.fields.activity')),
            'behavioral' => strtolower(trans('crud.study.fields.behavioral')),
            'physical' => strtolower(trans('crud.study.fields.physical')),
            'kbm' => strtolower(trans('crud.study.fields.kbm')),
            'artwork' => strtolower(trans('crud.study.fields.artwork')),
            'period' => strtolower(trans('crud.study.fields.period')),
            'source' => strtolower(trans('crud.study.fields.source')),
            'cost' => strtolower(trans('crud.study.fields.cost')),
            'partner_id' => strtolower(trans('crud.study.fields.partner')),
            'percentage' => strtolower(trans('crud.study.fields.percentage')),
            'team_statuses' => strtolower(trans('crud.study.fields.team_statuses')),
            'lesson_plan_id' => strtolower(trans('crud.study.fields.lesson_plan_id')),
            'budget_plan_id' => strtolower(trans('crud.study.fields.budget_plan_id'))
        ];
    }
}
