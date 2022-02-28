<?php

namespace App\Http\Requests;

use App\CurriculumCalendar;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCurriculumCalendarRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('curriculum_calendar_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:curriculum_calendars,id',
        ];

    }
}
