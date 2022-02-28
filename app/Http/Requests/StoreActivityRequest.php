<?php

namespace App\Http\Requests;

use App\Activity;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreActivityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:' . Activity::MAX_LENGTH_OF_NAME],
            'date' => ['required', 'date_format:' . config('panel.date_format')],
            'work_group_id' => ['required', 'integer', 'exists:work_groups,id'],
            'activity' => ['required', 'string', 'max:' . Activity::MAX_LENGTH_OF_ACTIVITY],
            'advantage' => ['required', 'string', 'max:' . Activity::MAX_LENGTH_OF_ADVANTAGE],
            'behavioral' => ['required', 'string', 'max:' . Activity::MAX_LENGTH_OF_BEHAVIORAL],
            'physical' => ['required', 'string', 'max:' . Activity::MAX_LENGTH_OF_PHYSICAL],
            'team_statuses.*' => ['integer', 'exists:team_statuses,id'],
            'team_statuses' => ['required', 'array'],
            'tutor' => ['required', 'string'],
            'document' => ['nullable', 'string', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'name' => strtolower(trans('crud.activity.fields.name')),
            'date' => strtolower(trans('crud.activity.fields.date')),
            'work_group_id' => strtolower(trans('crud.activity.fields.work_group')),
            'activity' => strtolower(trans('crud.activity.fields.activity')),
            'advantage' => strtolower(trans('crud.activity.fields.advantage')),
            'behavioral' => strtolower(trans('crud.activity.fields.behavioral')),
            'physical' => strtolower(trans('crud.activity.fields.physical')),
            'team_statuses.*' => strtolower(trans('crud.activity.fields.team_statuses')),
            'team_statuses' => strtolower(trans('crud.activity.fields.team_statuses')),
            'tutor' => strtolower(trans('crud.activity.fields.tutor')),
            'document' => strtolower(trans('crud.activity.fields.document')),
        ];
    }
}
