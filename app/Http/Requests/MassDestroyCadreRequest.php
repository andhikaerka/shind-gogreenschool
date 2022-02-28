<?php

namespace App\Http\Requests;

use App\Cadre;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCadreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cadre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:cadres,id',
        ];

    }
}
