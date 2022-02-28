<?php

namespace App\Http\Requests;

use App\Province;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateProvinceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('province_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'code' => ['required', 'numeric', 'digits:2', 'unique:provinces,code,' . request()->route('province')->id],
            'name' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'code' => strtolower(trans('crud.province.fields.code')),
            'name' => strtolower(trans('crud.province.fields.name')),
        ];
    }
}
