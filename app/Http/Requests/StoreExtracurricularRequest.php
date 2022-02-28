<?php

namespace App\Http\Requests;

use App\Extracurricular;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreExtracurricularRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('extracurricular_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'program' => ['required', 'string', 'max:'.Extracurricular::MAX_LENGTH_OF_PROGRAM],
            'time' => ['required', 'string', 'max:'.Extracurricular::MAX_LENGTH_OF_TIME],
            'activity' => ['required', 'string', 'max:'.Extracurricular::MAX_LENGTH_OF_ACTIVITY],
            'target' => ['required', 'string', 'max:'.Extracurricular::MAX_LENGTH_OF_TARGET],
            'tutor' => ['required', 'string', 'max:'.Extracurricular::MAX_LENGTH_OF_TUTOR],
            'participants' => ['required', 'array'],
            'participants*' => ['required', 'exists:teams'],
            'letter' => ['required', 'string'],
            'document' => ['required', 'string']
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.extracurricular.fields.school')),
            'program' => strtolower(trans('crud.extracurricular.fields.program')),
            'time' => strtolower(trans('crud.extracurricular.fields.time')),
            'activity' => strtolower(trans('crud.extracurricular.fields.activity')),
            'target' => strtolower(trans('crud.extracurricular.fields.target')),
            'tutor' => strtolower(trans('crud.extracurricular.fields.tutor')),
            'participants' => strtolower(trans('crud.extracurricular.fields.participants')),
            'letter' => strtolower(trans('crud.extracurricular.fields.letter')),
            'document' => strtolower(trans('crud.extracurricular.fields.document'))
        ];
    }
}
