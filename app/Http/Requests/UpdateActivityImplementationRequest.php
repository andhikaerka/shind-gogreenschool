<?php

namespace App\Http\Requests;

use App\ActivityImplementation;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateActivityImplementationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('activity_implementation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'date' => ['required', 'date_format:' . config('panel.date_format')],
            'work_group_id' => ['required', 'integer', 'exists:work_groups,id'],
            'activity_id' => ['required', 'integer', 'exists:activities,id'],
            'progress' => ['required', 'in:' . join(',', array_keys(ActivityImplementation::PROGRESS_SELECT))],
            'constraints' => ['required', 'string'],
            'plan' => ['required', 'string'],
            'document' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.activityImplementation.fields.school')),
            'date' => strtolower(trans('crud.activityImplementation.fields.date')),
            'work_group_id' => strtolower(trans('crud.activityImplementation.fields.work_group')),
            'activity_id' => strtolower(trans('crud.activityImplementation.fields.activity')),
            'progress' => strtolower(trans('crud.activityImplementation.fields.progress')),
            'constraints' => strtolower(trans('crud.activityImplementation.fields.constraints')),
            'plan' => strtolower(trans('crud.activityImplementation.fields.plan')),
            'document' => strtolower(trans('crud.activityImplementation.fields.document')),
        ];
    }
}
