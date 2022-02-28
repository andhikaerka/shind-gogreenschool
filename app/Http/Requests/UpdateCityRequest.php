<?php

namespace App\Http\Requests;

use App\City;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCityRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('city_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'code' => ['required', 'numeric', 'digits:4', 'unique:cities,code,' . request()->route('city')->id],
            'name' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'province_id' => strtolower(trans('crud.city.fields.province')),
            'code' => strtolower(trans('crud.city.fields.code')),
            'name' => strtolower(trans('crud.city.fields.name')),
        ];
    }
}
