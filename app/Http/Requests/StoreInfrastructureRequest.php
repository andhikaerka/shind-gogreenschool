<?php

namespace App\Http\Requests;

use App\Infrastructure;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreInfrastructureRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('infrastructure_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:' . Infrastructure::MAX_LENGTH_OF_NAME],
            'aspect_id' => ['required', 'exists:aspects,id'],
            'work_group_id' => ['required', 'exists:work_groups,id'],
            'total' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'function' => ['required', 'string', 'max:' . Infrastructure::MAX_LENGTH_OF_FUNCTION],
            'pic' => ['required', 'string', 'max:' . Infrastructure::MAX_LENGTH_OF_PIC],
            'photo' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.infrastructure.fields.school')),
            'name' => strtolower(trans('crud.infrastructure.fields.name')),
            'aspect_id' => strtolower(trans('crud.infrastructure.fields.aspect')),
            'work_group_id' => strtolower(trans('crud.infrastructure.fields.work_group')),
            'total' => strtolower(trans('crud.infrastructure.fields.total')),
            'function' => strtolower(trans('crud.infrastructure.fields.function')),
            'pic' => strtolower(trans('crud.infrastructure.fields.pic')),
            'photo' => strtolower(trans('crud.infrastructure.fields.photo')),
        ];
    }
}
