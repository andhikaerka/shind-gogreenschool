<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'permissions.*' => ['integer', 'exists:permissions,id'],
            'permissions' => ['required', 'array'],
        ];

    }

    public function attributes()
    {
        return [
            'title' => strtolower(trans('crud.role.fields.title')),
            'permissions.*' => strtolower(trans('crud.role.fields.permissions')),
            'permissions' => strtolower(trans('crud.role.fields.permissions')),
        ];
    }
}
