<?php


namespace App\Http\Requests;


use App\Curriculum;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreCurriculumRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('curriculum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'vision' => ['required', 'string'],
            'mission' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'calendars.*' => ['required', 'integer', 'exists:curriculum_calendars,id'],
            'calendars' => ['required', 'array'],
            'document' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.curriculum.fields.school')),
            'vision' => strtolower(trans('crud.curriculum.fields.vision')),
            'mission' => strtolower(trans('crud.curriculum.fields.mission')),
            'purpose' => strtolower(trans('crud.curriculum.fields.purpose')),
            'calendars.*' => strtolower(trans('crud.curriculum.fields.calendars')),
            'calendars' => strtolower(trans('crud.curriculum.fields.calendars')),
            'document' => strtolower(trans('crud.curriculum.fields.document')),
        ];
    }
}
