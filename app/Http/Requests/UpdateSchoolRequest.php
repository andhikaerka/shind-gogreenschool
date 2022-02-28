<?php

namespace App\Http\Requests;

use App\School;
use App\SchoolProfile;
use App\User;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateSchoolRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('school_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        $user = User::query()
            ->whereHas('school', function (\Illuminate\Database\Eloquent\Builder $builder) {
                if (auth()->user()->isSTC) {
                    $builder->where('slug', auth()->user()->school_slug);
                } else {
                    $builder->where('id', request()->route('school')->id);
                }
            })
            ->firstOrFail();

        return [
            'name' => ['required', 'string', 'max:' . School::MAX_LENGTH_OF_NAME],
            'level' => ['required', 'in:' . join(',', array_keys(School::LEVEL_SELECT))],
            'vision' => ['required', 'string', 'max:' . SchoolProfile::MAX_LENGTH_OF_VISION],
            'status' => ['required', 'in:' . join(',', array_keys(School::STATUS_SELECT))],
            'address' => ['required', 'string', 'max:' . School::MAX_LENGTH_OF_ADDRESS],
            'phone' => ['required', 'numeric', 'digits_between:10,20'],
            'email' => ['required', 'email', 'max:' . School::MAX_LENGTH_OF_EMAIL, 'unique:users,email,' . $user['id']],
            'website' => ['required', 'active_url', 'max:' . School::MAX_LENGTH_OF_WEBSITE],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'total_students' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'total_teachers' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'total_land_area' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'total_building_area' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'province' => ['required', 'exists:provinces,code'],
            'city' => ['required', 'exists:cities,code'],
            'logo' => ['nullable'],
            'photo' => ['nullable'],
            'year' => ['required', 'date_format:Y'],
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
            'website' => strtolower(trans('crud.school.fields.website')),
            'total_students' => strtolower(trans('crud.school.fields.total_students')),
            'total_teachers' => strtolower(trans('crud.school.fields.total_teachers')),
            'total_land_area' => strtolower(trans('crud.school.fields.total_land_area')),
            'total_building_area' => strtolower(trans('crud.school.fields.total_building_area')),
            'province' => strtolower(trans('crud.city.fields.province')),
            'city' => strtolower(trans('crud.school.fields.city')),
            'logo' => strtolower(trans('crud.school.fields.logo')),
            'photo' => strtolower(trans('crud.school.fields.photo')),
            'approved' => strtolower(trans('crud.user.fields.approved')),
            'year' => strtolower(trans('crud.schoolProfile.fields.year')),
        ];
    }
}
