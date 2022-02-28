<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'email' => ['required', 'unique:users', 'email', 'max:' . Builder::$defaultStringLength],
            'username' => ['required', 'alpha_num', 'starts_with:a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z', 'min:6', 'max:30', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'roles' => ['required', 'array'],
        ];

    }

    public function attributes()
    {
        return [
            'name' => strtolower(trans('crud.user.fields.name')),
            'email' => strtolower(trans('crud.user.fields.email')),
            'username' => strtolower(trans('crud.user.fields.username')),
            'roles.*' => strtolower(trans('crud.user.fields.roles')),
            'roles' => strtolower(trans('crud.user.fields.roles')),
        ];
    }
}
