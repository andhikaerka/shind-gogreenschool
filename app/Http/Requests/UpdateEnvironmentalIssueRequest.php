<?php

namespace App\Http\Requests;

use App\EnvironmentalIssue;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEnvironmentalIssueRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('environmental_issue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'potency' => ['required', 'string', 'max:'.EnvironmentalIssue::MAX_LENGTH_OF_POTENCY],
            'date' => ['required', 'date_format:' . config('panel.date_format')],
            'category' => ['required', 'string', 'in:'.join(',', EnvironmentalIssue::LIST_OF_CATEGORY)],
            'problem' => ['required', 'string', 'max:'.EnvironmentalIssue::MAX_LENGTH_OF_PROBLEM],
            'anticipation' => ['required', 'string', 'max:'.EnvironmentalIssue::MAX_LENGTH_OF_ANTICIPATION],
            'compiler' => ['required', 'string', 'max:'.EnvironmentalIssue::MAX_LENGTH_OF_COMPILER]
        ];

    }

    public function attributes()
    {
        return [
            'potency' => strtolower(trans('crud.environmentalIssue.fields.potency')),
            'date' => strtolower(trans('crud.environmentalIssue.fields.date')),
            'category' => strtolower(trans('crud.environmentalIssue.fields.category')),
            'problem' => strtolower(trans('crud.environmentalIssue.fields.problem')),
            'anticipation' => strtolower(trans('crud.environmentalIssue.fields.anticipation')),
            'compiler' => strtolower(trans('crud.environmentalIssue.fields.compiler')),
        ];
    }
}
