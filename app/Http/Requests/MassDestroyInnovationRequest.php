<?php

namespace App\Http\Requests;

use App\Innovation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyInnovationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('innovation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:innovations,id',
        ];

    }
}
