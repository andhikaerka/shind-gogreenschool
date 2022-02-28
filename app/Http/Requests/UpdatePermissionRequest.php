<?php

namespace App\Http\Requests;

use App\Permission;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePermissionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title' => ['required', 'alpha_dash', 'unique:permissions,title,' . request()->route('permission')->id, 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'title' => strtolower(trans('crud.permission.fields.title')),
        ];
    }
}
