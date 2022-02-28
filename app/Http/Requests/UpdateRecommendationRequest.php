<?php

namespace App\Http\Requests;

use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UpdateRecommendationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('recommendation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'work_program_id' => ['required', 'integer', 'exists:work_programs,id'],
            'cadre_activity_id' => ['required', 'integer', 'exists:cadre_activities,id'],
            'recommendation' => ['required', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'work_program_id' => 'nama proker',
            'cadre_activity_id' => 'kegiatan',
            'recommendation' => 'rekomendasi',
        ];
    }
}
