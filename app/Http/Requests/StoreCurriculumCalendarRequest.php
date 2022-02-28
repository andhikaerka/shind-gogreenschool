<?php

namespace App\Http\Requests;

use App\CurriculumCalendar;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCurriculumCalendarRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('curriculum_calendar_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:' . Builder::$defaultStringLength],
        ];

    }

    public function attributes()
    {
        return [
            'name' => strtolower(trans('crud.curriculumCalendar.fields.name')),
        ];
    }
}
