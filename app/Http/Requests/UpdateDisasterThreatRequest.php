<?php

namespace App\Http\Requests;

use App\DisasterThreat;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateDisasterThreatRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('disaster_threat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'name' => strtolower(trans('crud.disasterThreat.fields.name')),
        ];
    }
}
