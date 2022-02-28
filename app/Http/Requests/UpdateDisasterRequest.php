<?php

namespace App\Http\Requests;

use App\Disaster;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateDisasterRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('disaster_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'potential' => ['required', 'string'],
            'vulnerability' => ['required', 'string'],
            'impact' => ['required', 'string'],
            'threats.*' => ['integer', 'exists:disaster_threats,id'],
            'threats' => ['required', 'array'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.disaster.fields.school')),
            'potential' => strtolower(trans('crud.disaster.fields.potential')),
            'vulnerability' => strtolower(trans('crud.disaster.fields.vulnerability')),
            'impact' => strtolower(trans('crud.disaster.fields.impact')),
            'threats.*' => strtolower(trans('crud.disaster.fields.threats')),
            'threats' => strtolower(trans('crud.disaster.fields.threats')),
        ];
    }
}
