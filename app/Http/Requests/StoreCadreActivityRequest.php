<?php

namespace App\Http\Requests;

use App\CadreActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCadreActivityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cadre_activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        $maxPercentage = CadreActivity::MAX_PERCENTAGE;
        $percentageAmountNow = CadreActivity::query()
            ->whereHas('work_program.study.work_group.school_profile.school', function (Builder $builder) {
                $builder->where('slug', auth()->user()->school_slug);
            })
            ->sum('percentage');
        $maxPercentage = $maxPercentage - $percentageAmountNow;

        return [
            'self_development' => ['required', 'string', 'in:'.join(',', CadreActivity::LIST_OF_SELF_DEVELOPMENT)],
            'date' => ['required', 'date_format:' . config('panel.date_format')],
            'work_group_id' => ['required', 'integer', 'exists:work_groups,id'],
            'work_program_id' => ['required', 'integer', 'exists:work_programs,id'],
            'condition' => ['required', 'in:' . join(',', array_keys(CadreActivity::CONDITION_SELECT))],
            // 'percentage' => ['required', 'integer', 'max:' . $maxPercentage],
            'results' => ['required', 'string', 'max:' . CadreActivity::MAX_LENGTH_OF_RESULTS],
            'problem' => ['required', 'string', 'max:' . CadreActivity::MAX_LENGTH_OF_PROBLEM],
            'behavioral' => ['required', 'string', 'max:' . CadreActivity::MAX_LENGTH_OF_BEHAVIORAL],
            'physical' => ['required', 'string', 'max:' . CadreActivity::MAX_LENGTH_OF_PHYSICAL],
            'plan' => ['required', 'string', 'max:' . CadreActivity::MAX_LENGTH_OF_PLAN],
            'team_statuses.*' => ['integer', 'exists:team_statuses,id'],
            'team_statuses' => ['required', 'array'],
            'document' => ['nullable', 'string', 'max:' . \Illuminate\Database\Schema\Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'self_development' => strtolower(trans('crud.cadreActivity.fields.self_development')),
            'date' => strtolower(trans('crud.cadreActivity.fields.date')),
            'work_group_id' => strtolower(trans('crud.cadreActivity.fields.work_group')),
            'work_program_id' => strtolower(trans('crud.cadreActivity.fields.work_program')),
            'condition' => strtolower(trans('crud.cadreActivity.fields.condition')),
            'percentage' => strtolower(trans('crud.cadreActivity.fields.percentage')),
            'results' => strtolower(trans('crud.cadreActivity.fields.results')),
            'problem' => strtolower(trans('crud.cadreActivity.fields.problem')),
            'behavioral' => strtolower(trans('crud.cadreActivity.fields.behavioral')),
            'physical' => strtolower(trans('crud.cadreActivity.fields.physical')),
            'plan' => strtolower(trans('crud.cadreActivity.fields.plan')),
            'team_statuses.*' => strtolower(trans('crud.cadreActivity.fields.team_statuses')),
            'team_statuses' => strtolower(trans('crud.cadreActivity.fields.team_statuses')),
            'document' => strtolower(trans('crud.cadreActivity.fields.document')),
        ];
    }
}
