<?php

namespace App\Http\Requests;

use App\Partner;
use App\PartnerActivity;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePartnerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('partner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:' . Partner::MAX_LENGTH_OF_NAME],
            'cp_name' => ['required', 'string', 'max:' . Partner::MAX_LENGTH_OF_CP_NAME],
            'cp_phone' => ['required', 'string', 'digits_between:10,20', 'max:' . Builder::$defaultStringLength],
            'partner_category_id' => ['required', 'exists:partner_categories,id'],
            'partner_activity_id' => ['required'],
            'date' => ['required', 'date_format:' . config('panel.date_format')],
            'purpose' => ['required', 'string', 'max:' . Partner::MAX_LENGTH_OF_PURPOSE],
            'total_people' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'photo' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.partner.fields.school')),
            'name' => strtolower(trans('crud.partner.fields.name')),
            'cp_name' => strtolower(trans('crud.partner.fields.cp_name')),
            'cp_phone' => strtolower(trans('crud.partner.fields.cp_phone')),
            'partner_category_id' => strtolower(trans('crud.partner.fields.partner_category')),
            'partner_activity_id' => strtolower(trans('crud.partner.fields.partner_activity')),
            'date' => strtolower(trans('crud.partner.fields.date')),
            'purpose' => strtolower(trans('crud.partner.fields.purpose')),
            'total_people' => strtolower(trans('crud.partner.fields.total_people')),
            'photo' => strtolower(trans('crud.partner.fields.photo')),
        ];
    }
}
