@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.monitor.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.monitors.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.date') }}
                        </th>
                        <td>
                            {{ $monitor->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.work_group') }}
                        </th>
                        <td>
                            {{ $monitor->work_group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.potential') }}
                        </th>
                        <td>
                            {{ $monitor->potential }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.problem') }}
                        </th>
                        <td>
                            {{ $monitor->problem }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.monitor') }}
                        </th>
                        <td>
                            {{ $monitor->monitor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.behavioral') }}
                        </th>
                        <td>
                            {{ $monitor->behavioral }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.physical') }}
                        </th>
                        <td>
                            {{ $monitor->physical }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.cost') }}
                        </th>
                        <td>
                            {{ $monitor->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.monitor.fields.partner') }}
                        </th>
                        <td>
                            {{ $monitor->partner->name ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.monitors.index', ['school_slug' => $school_slug]) }}">
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
                <a class="nav-link" href="#monitor_work_programs" role="tab" data-toggle="tab">
                    {{ trans('crud.workProgram.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="monitor_work_programs">
                @includeIf('school.monitors.relationships.monitorWorkPrograms', ['workPrograms' => $monitor->monitorWorkPrograms])
            </div>
        </div>
    </div>--}}

@endsection
