<?php

namespace App\Http\Requests;

use App\Environment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEnvironmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'has_file' => ['nullable', 'boolean'],
            'file' => ['nullable', 'string'],
            'compiler' => ['required', 'string', 'max:100'],
            'isi' => ['required', 'string', 'max:100'],
            'proses' => ['required', 'string', 'max:100'],
            'kompetensi_kelulusan' => ['required', 'string', 'max:100'],
            'pendidik_dan_tenaga_kependidikan' => ['required', 'string', 'max:100'],
            'sarana_prasarana' => ['required', 'string', 'max:100'],
            'pengelolaan' => ['required', 'string', 'max:100'],
            'pembiayaan' => ['required', 'string', 'max:100'],
            'penilaian_pendidikan' => ['required', 'string', 'max:100'],
        ];

    }

    public function attributes()
    {
        return [
            'has_file' => strtolower(trans('crud.qualityReport.fields.has_file')),
            'proses' => strtolower(trans('crud.qualityReport.fields.proses')),
            'compiler' => strtolower(trans('crud.qualityReport.fields.compiler')),
            'isi' => strtolower(trans('crud.qualityReport.fields.isi')),
            'kompetensi_kelulusan' => strtolower(trans('crud.qualityReport.fields.kompetensi_kelulusan')),
            'pendidik_dan_tenaga_kependidikan' => strtolower(trans('crud.qualityReport.fields.pendidik_dan_tenaga_kependidikan')),
            'sarana_prasarana' => strtolower(trans('crud.qualityReport.fields.sarana_prasarana')),
            'pengelolaan' => strtolower(trans('crud.qualityReport.fields.pengelolaan')),
            'pembiayaan' => strtolower(trans('crud.qualityReport.fields.pembiayaan')),
            'penilaian_pendidikan' => strtolower(trans('crud.qualityReport.fields.penilaian_pendidikan')),
        ];
    }
}
