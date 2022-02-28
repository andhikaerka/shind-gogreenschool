<?php

namespace App\Http\Requests;

use App\WorkProgram;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreWorkProgramRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('work_program_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        $maxPercentage = WorkProgram::MAX_PERCENTAGE;
        $study = \App\Study::find(request()->get('study_id'))->work_group_id ?? null;
        $percentageAmountNow = WorkProgram::query()
            ->whereHas('study', function (\Illuminate\Database\Eloquent\Builder $builder) use($study) {
                $builder->where('work_group_id', $study);
            })
            ->whereHas('study.work_group.school_profile.school', function (\Illuminate\Database\Eloquent\Builder $builder) {
                $builder->where('slug', auth()->user()->school_slug);
            })
            ->sum('percentage');
        $maxPercentage = $maxPercentage - $percentageAmountNow;

        return [
            'name' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'study_id' => ['required', 'integer', 'exists:studies,id'],
            'condition' => ['required', 'string'],
            'plan' => ['required', 'string'],
            // 'checklist_templates.*' => ['integer', 'exists:checklist_templates,id'],
            // 'checklist_templates' => ['required', 'array'],
            // 'activity' => ['nullable', 'string'],
            'time' => ['required', 'integer', 'min:' . WorkProgram::MIN_TIME, 'max:' . WorkProgram::MAX_TIME],
            'percentage' => ['required', 'integer', 'min:' . WorkProgram::MIN_PERCENTAGE, 'max:' . $maxPercentage],
            'tutor_1' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'tutor_2' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'tutor_3' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'featured' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'name' => strtolower(trans('crud.workProgram.fields.name')),
            'study_id' => strtolower(trans('crud.workProgram.fields.study')),
            'condition' => strtolower(trans('crud.workProgram.fields.condition')),
            'plan' => strtolower(trans('crud.workProgram.fields.plan')),
            'checklist_templates' => strtolower(trans('crud.study.fields.checklist_templates')),
            'activity' => strtolower(trans('crud.study.fields.activity')),
            'time' => strtolower(trans('crud.workProgram.fields.time')),
            'percentage' => strtolower(trans('crud.workProgram.fields.percentage')),
            'tutor_1' => strtolower(trans('crud.workProgram.fields.tutor_1')),
            'tutor_2' => strtolower(trans('crud.workProgram.fields.tutor_2')),
            'tutor_3' => strtolower(trans('crud.workProgram.fields.tutor_3')),
            'featured' => strtolower(trans('crud.workProgram.fields.featured')),
            'photo' => strtolower(trans('crud.workProgram.fields.photo')),
        ];
    }
}
