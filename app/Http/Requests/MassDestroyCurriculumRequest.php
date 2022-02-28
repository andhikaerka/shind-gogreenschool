<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCurriculumRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('curriculum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:curricula,id',
        ];

    }
}
