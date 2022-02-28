<?php

namespace App\Http\Requests;

use App\LessonPlan;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreLessonPlanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('lesson_plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'environmental_issue_id' => ['required', 'exists:environmental_issues,id'],
            'subject' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'teacher' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'class' => ['required', 'in:' . join(',', array_keys(LessonPlan::CLASS_SELECT))],
            'aspect_id' => ['required', 'exists:aspects,id'],
            'hook' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'artwork' => ['required', 'string'],
            'hour' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'period' => ['required', 'in:' . join(',', array_keys(LessonPlan::PERIOD_SELECT))],
            'syllabus' => ['nullable', 'string'],
            'rpp' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.lessonPlan.fields.school')),
            'environmental_issue_id' => strtolower(trans('crud.lessonPlan.fields.environmental_issue_id')),
            'subject' => strtolower(trans('crud.lessonPlan.fields.subject')),
            'teacher' => strtolower(trans('crud.lessonPlan.fields.teacher')),
            'class' => strtolower(trans('crud.lessonPlan.fields.class')),
            'aspect_id' => strtolower(trans('crud.lessonPlan.fields.aspect')),
            'hook' => strtolower(trans('crud.lessonPlan.fields.hook')),
            'artwork' => strtolower(trans('crud.lessonPlan.fields.artwork')),
            'hour' => strtolower(trans('crud.lessonPlan.fields.hour')),
            'period' => strtolower(trans('crud.lessonPlan.fields.period')),
            'syllabus' => strtolower(trans('crud.lessonPlan.fields.syllabus')),
            'rpp' => strtolower(trans('crud.lessonPlan.fields.rpp')),
        ];
    }
}
