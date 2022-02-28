<?php

namespace App\Http\Requests;

use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreMonitorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('monitor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'date' => ['required', 'date_format:' . config('panel.date_format')],
            'work_group_id' => ['required', 'integer', 'exists:work_groups,id'],
            'team_statuses.*' => ['integer', 'exists:team_statuses,id'],
            'team_statuses' => ['required', 'array'],
            'document' => ['nullable', 'string', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'date' => strtolower(trans('crud.monitor.fields.date')),
            'work_group_id' => strtolower(trans('crud.monitor.fields.work_group')),
            'team_statuses.*' => strtolower(trans('crud.monitor.fields.team_statuses')),
            'team_statuses' => strtolower(trans('crud.monitor.fields.team_statuses')),
            'document' => strtolower(trans('crud.monitor.fields.document')),
        ];
    }
}
