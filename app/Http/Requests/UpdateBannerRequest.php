<?php

namespace App\Http\Requests;

use App\Banner;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateBannerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
            'image' => ['nullable', 'string', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'slug' => strtolower(trans('crud.banner.fields.slug')),
            'title' => strtolower(trans('crud.banner.fields.title')),
            'image' => strtolower(trans('crud.banner.fields.image')),
        ];
    }
}
