<?php

namespace App\Http\Requests;

use App\Permission;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePermissionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title' => ['required', 'alpha_dash', 'unique:permissions', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'title' => strtolower(trans('crud.permission.fields.title')),
        ];
    }
}
