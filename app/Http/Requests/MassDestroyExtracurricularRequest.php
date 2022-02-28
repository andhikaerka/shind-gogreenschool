<?php

namespace App\Http\Requests;

use App\Extracurricular;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyExtracurricularRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('extracurricular_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'ids' => 'required|array',
            'ids.*' => 'exists:extracurriculars,id',
        ];

    }
}
