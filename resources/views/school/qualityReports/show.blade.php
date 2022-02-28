@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.qualityReport.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.quality-reports.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.qualityReport.fields.document') }}
                        </th>
                        <td>
                            @if($qualityReport->document)
                                <a href="{{ $qualityReport->document->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.qualityReport.fields.waste_management') }}
                        </th>
                        <td>
                            {{ $qualityReport->waste_management }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.qualityReport.fields.energy_conservation') }}
                        </th>
                        <td>
                            {{ $qualityReport->energy_conservation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.qualityReport.fields.life_preservation') }}
                        </th>
                        <td>
                            {{ $qualityReport->life_preservation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.qualityReport.fields.water_conservation') }}
                        </th>
                        <td>
                            {{ $qualityReport->water_conservation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.qualityReport.fields.canteen_management') }}
                        </th>
                        <td>
                            {{ $qualityReport->canteen_management }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.qualityReport.fields.letter') }}
                        </th>
                        <td>
                            @if($qualityReport->letter)
                                <a href="{{ $qualityReport->letter->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.quality-reports.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#quality_report_studies" role="tab" data-toggle="tab">
                    {{ trans('crud.study.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="quality_report_studies">
                @includeIf('school.qualityReports.relationships.qualityReportStudies', ['studies' => $qualityReport->qualityReportStudies])
            </div>
        </div>
    </div>--}}

@endsection
