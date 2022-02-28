<?php

namespace App\Http\Requests;

use App\WorkGroup;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWorkGroupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('work_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:work_groups,id',
        ];

    }
}
