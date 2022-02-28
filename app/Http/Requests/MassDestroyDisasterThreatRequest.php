<?php

namespace App\Http\Requests;

use App\DisasterThreat;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDisasterThreatRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('disaster_threat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:disaster_threats,id',
        ];

    }
}
