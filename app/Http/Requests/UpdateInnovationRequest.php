<?php

namespace App\Http\Requests;

use App\Innovation;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateInnovationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('innovation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:' . Innovation::MAX_LENGTH_OF_NAME],
            'work_group_id' => ['required', 'integer', 'exists:work_groups,id'],
            'activity' => ['required', 'string', 'max:' . Innovation::MAX_LENGTH_OF_ACTIVITY],
            'tutor' => ['required', 'string', 'max:' . Innovation::MAX_LENGTH_OF_TUTOR],
            'purpose' => ['required', 'string', 'max:' . Innovation::MAX_LENGTH_OF_PURPOSE],
            'team_statuses.*' => ['integer', 'exists:team_statuses,id'],
            'team_statuses' => ['required', 'array'],
            'advantage' => ['required', 'string', 'max:' . Innovation::MAX_LENGTH_OF_ADVANTAGE],
            'innovation' => ['required', 'string', 'max:' . Innovation::MAX_LENGTH_OF_INNOVATION],
            'photo' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'name' => strtolower(trans('crud.innovation.fields.name')),
            'work_group_id' => strtolower(trans('crud.innovation.fields.work_group')),
            'activity' => strtolower(trans('crud.innovation.fields.activity')),
            'tutor' => strtolower(trans('crud.innovation.fields.tutor')),
            'purpose' => strtolower(trans('crud.innovation.fields.purpose')),
            'team_statuses.*' => strtolower(trans('crud.innovation.fields.team_statuses')),
            'team_statuses' => strtolower(trans('crud.innovation.fields.team_statuses')),
            'advantage' => strtolower(trans('crud.innovation.fields.advantage')),
            'innovation' => strtolower(trans('crud.innovation.fields.innovation')),
            'photo' => strtolower(trans('crud.innovation.fields.photo')),
        ];
    }
}
