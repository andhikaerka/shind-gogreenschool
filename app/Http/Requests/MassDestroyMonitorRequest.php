<?php

namespace App\Http\Requests;

use App\Banner;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMonitorRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('monitor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:monitors,id',
        ];

    }
}
