@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.study.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.studies.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.quality_report') }}
                        </th>
                        <td>
                            #{{ $study->quality_report_id ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.infrastructure.fields.aspect') }}
                        </th>
                        <td>
                            {{ trans('crud.qualityReport.fields.waste_management') }}
                            : {{ $study->quality_report->waste_management ?? '' }}<br>
                            {{ trans('crud.qualityReport.fields.energy_conservation') }}
                            : {{ $study->quality_report->energy_conservation ?? '' }}<br>
                            {{ trans('crud.qualityReport.fields.life_preservation') }}
                            : {{ $study->quality_report->life_preservation ?? '' }}<br>
                            {{ trans('crud.qualityReport.fields.water_conservation') }}
                            : {{ $study->quality_report->water_conservation ?? '' }}<br>
                            {{ trans('crud.qualityReport.fields.canteen_management') }}
                            : {{ $study->quality_report->canteen_management ?? '' }}<br>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.work_group') }}
                        </th>
                        <td>
                            {{ $study->work_group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.potential') }}
                        </th>
                        <td>
                            {{ $study->potential }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.problem') }}
                        </th>
                        <td>
                            {{ $study->problem }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.activity') }}
                        </th>
                        <td>
                            {{ $study->activity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.behavioral') }}
                        </th>
                        <td>
                            {{ $study->behavioral }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.physical') }}
                        </th>
                        <td>
                            {{ $study->physical }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.kbm') }}
                        </th>
                        <td>
                            {{ $study->kbm }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.artwork') }}
                        </th>
                        <td>
                            {{ $study->artwork }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.period') }}
                        </th>
                        <td>
                            {{ App\Study::PERIOD_SELECT[$study->period] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.source') }}
                        </th>
                        <td>
                            {{ App\Study::SOURCE_SELECT[$study->source] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.cost') }}
                        </th>
                        <td>
                            {{ $study->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.study.fields.partner') }}
                        </th>
                        <td>
                            {{ $study->partner->name ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.studies.index') }}">
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
                <a class="nav-link" href="#study_work_programs" role="tab" data-toggle="tab">
                    {{ trans('crud.workProgram.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="study_work_programs">
                @includeIf('admin.studies.relationships.studyWorkPrograms', ['workPrograms' => $study->studyWorkPrograms])
            </div>
        </div>
    </div>--}}

@endsection
