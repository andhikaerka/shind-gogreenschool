<?php

namespace App\Http\Requests;

use App\EnvironmentalIssue;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEnvironmentalIssueRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('environmental_issue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:environmental_issues,id',
        ];

    }
}
