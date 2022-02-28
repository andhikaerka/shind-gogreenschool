<?php

namespace App\Http\Requests;

use App\ActivityImplementation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyActivityImplementationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('activity_implementation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:activity_implementations,id',
        ];

    }
}
