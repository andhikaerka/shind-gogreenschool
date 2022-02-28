<?php

namespace App\Http\Requests;

use App\Cadre;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCadreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cadre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'work_group_id' => ['required', 'integer', 'exists:work_groups,id'],
            'name' => ['required', 'string', 'max:' . Cadre::MAX_LENGTH_OF_NAME],
            'email' => ['required', 'unique:users,email,' . request()->route('cadre')->user_id, 'email', 'max:' . Builder::$defaultStringLength],
            'gender' => ['required', 'in:' . join(',', array_keys(Cadre::GENDER_SELECT))],
            'class' => ['required', 'in:' . join(',', array_keys(Cadre::CLASS_SELECT))],
            'phone' => ['required', 'numeric', 'digits_between:10,20'],
            'birth_date' => ['required', 'date_format:' . config('panel.date_format')],
            'address' => ['required', 'string', 'max:' . Cadre::MAX_LENGTH_OF_ADDRESS],
            'hobby' => ['required', 'string', 'max:' . Cadre::MAX_LENGTH_OF_HOBBY],
            'position' => ['required', 'string'],
            // 'position' => ['required', 'in:' . join(',', array_keys(Cadre::POSITION_SELECT))],
            'photo' => ['nullable', 'string'],
            'letter' => ['nullable', 'string'],
            //'username' => ['required', 'alpha_num', 'starts_with:a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z', 'min:6', 'max:30', 'unique:users,username,' . request()->route('cadre')->user_id],
            //'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

    }

    public function attributes()
    {
        return [
            'work_group_id' => strtolower(trans('crud.cadre.fields.work_group')),
            'name' => strtolower(trans('crud.user.fields.name')),
            'gender' => strtolower(trans('crud.cadre.fields.gender')),
            'class' => strtolower(trans('crud.cadre.fields.class')),
            'phone' => strtolower(trans('crud.cadre.fields.phone')),
            'birth_date' => strtolower(trans('crud.cadre.fields.birth_date')),
            'address' => strtolower(trans('crud.cadre.fields.address')),
            'hobby' => strtolower(trans('crud.cadre.fields.hobby')),
            'position' => strtolower(trans('crud.cadre.fields.position')),
            'photo' => strtolower(trans('crud.cadre.fields.photo')),
            'letter' => strtolower(trans('crud.cadre.fields.letter')),
            'username' => strtolower(trans('crud.user.fields.username')),
            'password' => strtolower(trans('crud.user.fields.password')),
        ];
    }
}
