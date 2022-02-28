<?php

namespace App\Http\Requests;

use App\Habituation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyHabituationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('habituation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:habituations,id',
        ];

    }
}
