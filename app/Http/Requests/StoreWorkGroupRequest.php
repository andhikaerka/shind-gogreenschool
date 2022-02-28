<?php

namespace App\Http\Requests;

use App\WorkGroup;
use App\SchoolProfile;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class StoreWorkGroupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('work_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        $schoolProfile = SchoolProfile::where('school_id', auth()->user()->isSTC)->where('year', request()->get('year', date('Y')))->first();
        $schoolProfile = $schoolProfile->id ?? null;
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'year' => ['digits:4', 'nullable'],
            'name' => ['required', 'string', 'exists:work_group_names,name', 'max:' . Builder::$defaultStringLength],
            'work_group_name_id' => ['required', 'exists:work_group_names,id', Rule::unique('work_groups')->where(function ($query) use($schoolProfile) {
                return $query->where('school_profile_id', $schoolProfile);
            })],
            /*'alias' => [
                function ($attribute, $value, $fail) {
                    if (request()->get('work_group_name_id') == 18 && is_null($value)) {
                        $fail(trans('validation.required', ['attribute' => strtolower(trans('crud.workGroup.fields.work_group_name'))]));
                    }
                },
                'max:' . Builder::$defaultStringLength],*/
            'description' => ['required', 'string', 'max:' . WorkGroup::MAX_LENGTH_OF_DESCRIPTION],
//            'email' => ['required', 'unique:users,email', 'email', 'max:' . Builder::$defaultStringLength],
            'aspect_id' => ['required', 'exists:aspects,id'],
            'tutor' => ['required', 'string', 'max:' . WorkGroup::MAX_LENGTH_OF_TUTOR],
            'tutor_1' => ['nullable', 'string', 'max:' . Builder::$defaultStringLength],
            'tutor_2' => ['nullable', 'string', 'max:' . Builder::$defaultStringLength],
            'task' => ['required', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.workGroup.fields.school')),
            'year' => strtolower(trans('crud.schoolProfile.fields.year')),
            'name' => strtolower(trans('crud.workGroup.fields.name')),
            'work_group_name_id' => strtolower(trans('crud.workGroup.fields.work_group_name')),
            'alias' => strtolower(trans('crud.workGroup.fields.alias')),
            'description' => strtolower(trans('crud.workGroup.fields.description')),
            'email' => strtolower(trans('crud.workGroup.fields.email')),
            'aspect_id' => strtolower(trans('crud.workGroup.fields.aspect')),
            'field' => strtolower(trans('crud.workGroup.fields.field')),
            'tutor' => strtolower(trans('crud.workGroup.fields.tutor')),
            'tutor_1' => strtolower(trans('crud.workGroup.fields.tutor_1')),
            'tutor_2' => strtolower(trans('crud.workGroup.fields.tutor_2')),
            'task' => strtolower(trans('crud.workGroup.fields.task')),
        ];
    }
}
