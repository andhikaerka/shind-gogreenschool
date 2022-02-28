<?php

namespace App\Http\Requests;

use App\School;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSchoolRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('school_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'level' => ['required', 'in:' . join(',', array_keys(School::LEVEL_SELECT))],
            'vision' => ['required', 'string'],
            'status' => ['required', 'in:' . join(',', array_keys(School::STATUS_SELECT))],
            'address' => ['required', 'string'],
            'phone' => ['required', 'numeric', 'digits_between:10,20'],
            'email' => ['required', 'email', 'max:' . Builder::$defaultStringLength, 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'total_students' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'total_teachers' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'total_land_area' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'total_building_area' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'logo' => ['nullable'],
            'photo' => ['nullable'],
        ];

    }

    public function attributes()
    {
        return [
            'name' => strtolower(trans('crud.school.fields.name')),
            'level' => strtolower(trans('crud.school.fields.level')),
            'vision' => strtolower(trans('crud.school.fields.vision')),
            'status' => strtolower(trans('crud.school.fields.status')),
            'address' => strtolower(trans('crud.school.fields.address')),
            'phone' => strtolower(trans('crud.school.fields.phone')),
            'email' => strtolower(trans('crud.school.fields.email')),
            'total_students' => strtolower(trans('crud.school.fields.total_students')),
            'total_teachers' => strtolower(trans('crud.school.fields.total_teachers')),
            'total_land_area' => strtolower(trans('crud.school.fields.total_land_area')),
            'total_building_area' => strtolower(trans('crud.school.fields.total_building_area')),
            'city_id' => strtolower(trans('crud.school.fields.city')),
            'logo' => strtolower(trans('crud.school.fields.logo')),
            'photo' => strtolower(trans('crud.school.fields.photo')),
        ];
    }
}
