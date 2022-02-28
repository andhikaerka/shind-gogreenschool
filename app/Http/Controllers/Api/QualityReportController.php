<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\QualityReport;
use Illuminate\Http\Request;

class QualityReportController extends Controller
{
    public function index(Request $request)
    {
        $qualityReports = QualityReport::query()
            ->selectRaw("id, CONCAT('" . (trans('crud.qualityReport.fields.waste_management')) . ": ', waste_management, '; " . (trans('crud.qualityReport.fields.life_preservation')) . ": ', life_preservation, '; " . (trans('crud.qualityReport.fields.water_conservation')) . ": ', water_conservation, '; " . (trans('crud.qualityReport.fields.canteen_management')) . ": ', canteen_management, '; " . (trans('crud.qualityReport.fields.energy_conservation')) . ": ', energy_conservation) AS text, waste_management, life_preservation, water_conservation, canteen_management, energy_conservation")
            ->where('school_id', $request->get('school'))
            ->where('has_document', true)
            ->get()
            ->prepend([
                'id' => '',
                'text' => trans('global.pleaseSelect'),
                'waste_management' => '',
                'life_preservation' => '',
                'water_conservation' => '',
                'canteen_management' => '',
                'energy_conservation' => ''
            ])
            ->toArray();

        return response()->json($qualityReports);
    }
}
