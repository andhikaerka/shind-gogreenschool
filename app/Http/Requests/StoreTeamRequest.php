<?php

namespace App\Http\Requests;

use App\Team;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreTeamRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            // 'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:' . Team::MAX_LENGTH_OF_NAME],
            'team_status_id' => ['required', 'exists:team_statuses,id'],
            'gender' => ['required', 'in:' . join(',', array_keys(Team::GENDER_SELECT))],
            'birth_date' => ['required', 'date_format:' . config('panel.date_format')],
            'aspect_id' => ['required', 'exists:aspects,id'],
            'work_group_id' => ['required', 'exists:work_groups,id'],
            'job_description' => ['required', 'string'],
            'team_position_id' => ['required', 'exists:team_positions,id'],
            'another_position' => ['nullable', 'required_if:team_position_id,7', 'string', 'max:' . Builder::$defaultStringLength],
            'document' => ['nullable', 'string'],
            'email' => ['required', 'email', 'max:' . Builder::$defaultStringLength],
            // 'username' => ['required', 'alpha_num', 'starts_with:a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z', 'min:6', 'max:30', 'unique:users,username'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.team.fields.school')),
            'name' => strtolower(trans('crud.team.fields.name')),
            'team_status_id' => strtolower(trans('crud.team.fields.team_status')),
            'gender' => strtolower(trans('crud.team.fields.gender')),
            'birth_date' => strtolower(trans('crud.team.fields.birth_date')),
            'aspect_id' => strtolower(trans('crud.team.fields.aspect')),
            'work_group_id' => strtolower(trans('crud.team.fields.work_group')),
            'job_description' => strtolower(trans('crud.team.fields.job_description')),
            'team_position_id' => strtolower(trans('crud.team.fields.team_position')),
            'another_position' => strtolower(trans('crud.team.fields.another_position')),
            'document' => strtolower(trans('crud.team.fields.document')),
            'username' => strtolower(trans('crud.user.fields.username')),
            'password' => strtolower(trans('crud.user.fields.password')),
        ];
    }

    public function messages()
    {
        return [
            'another_position.required_if' => trans('validation.required'),
        ];
    }
}
