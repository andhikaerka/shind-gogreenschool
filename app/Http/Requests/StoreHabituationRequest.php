<?php

namespace App\Http\Requests;

use App\Habituation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreHabituationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('habituation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'program' => ['required', 'string', 'max:'.Habituation::MAX_LENGTH_OF_PROGRAM],
            'category' => ['required', 'string', 'in:'.join(',', Habituation::LIST_OF_CATEGORY)],
            'time' => ['required', 'string', 'max:'.Habituation::MAX_LENGTH_OF_TIME],
            'activity' => ['required', 'string', 'max:'.Habituation::MAX_LENGTH_OF_ACTIVITY],
            'target' => ['required', 'string', 'max:'.Habituation::MAX_LENGTH_OF_TARGET],
            'tutor' => ['required', 'string', 'max:'.Habituation::MAX_LENGTH_OF_TUTOR],
            'participants' => ['required', 'array'],
            'participants*' => ['required', 'exists:teams'],
            'letter' => ['required', 'string'],
            'document' => ['required', 'string']
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.habituation.fields.school')),
            'category' => strtolower(trans('crud.habituation.fields.category')),
            'program' => strtolower(trans('crud.habituation.fields.program')),
            'time' => strtolower(trans('crud.habituation.fields.time')),
            'activity' => strtolower(trans('crud.habituation.fields.activity')),
            'target' => strtolower(trans('crud.habituation.fields.target')),
            'tutor' => strtolower(trans('crud.habituation.fields.tutor')),
            'participants' => strtolower(trans('crud.habituation.fields.participants')),
            'letter' => strtolower(trans('crud.habituation.fields.letter')),
            'document' => strtolower(trans('crud.habituation.fields.document'))
        ];
    }
}
