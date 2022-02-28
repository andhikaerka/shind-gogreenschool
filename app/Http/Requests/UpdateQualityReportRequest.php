<?php

namespace App\Http\Requests;

use App\QualityReport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateQualityReportRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'has_document' => ['nullable', 'boolean'],
            'document' => ['nullable', 'string'],
            'waste_management' => ['required', 'string', 'max:' . QualityReport::MAX_LENGTH_OF_WASTE_MANAGEMENT],
            'energy_conservation' => ['required', 'string', 'max:' . QualityReport::MAX_LENGTH_OF_ENERGY_CONSERVATION],
            'life_preservation' => ['required', 'string', 'max:' . QualityReport::MAX_LENGTH_OF_LIFE_PRESERVATION],
            'water_conservation' => ['required', 'string', 'max:' . QualityReport::MAX_LENGTH_OF_WATER_CONSERVATION],
            'canteen_management' => ['required', 'string', 'max:' . QualityReport::MAX_LENGTH_OF_CANTEEN_MANAGEMENT],
            'letter' => ['nullable', 'string'],
        ];

    }

    public function attributes()
    {
        return [
            'school_id' => strtolower(trans('crud.qualityReport.fields.school')),
            'has_document' => strtolower(trans('crud.qualityReport.fields.has_document')),
            'document' => strtolower(trans('crud.qualityReport.fields.document')),
            'waste_management' => strtolower(trans('crud.qualityReport.fields.waste_management')),
            'energy_conservation' => strtolower(trans('crud.qualityReport.fields.energy_conservation')),
            'life_preservation' => strtolower(trans('crud.qualityReport.fields.life_preservation')),
            'water_conservation' => strtolower(trans('crud.qualityReport.fields.water_conservation')),
            'canteen_management' => strtolower(trans('crud.qualityReport.fields.canteen_management')),
            'letter' => strtolower(trans('crud.qualityReport.fields.letter')),
        ];
    }
}
