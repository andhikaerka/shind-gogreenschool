@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.activityImplementation.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.activity-implementations.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.school.title_singular') }}
                        </th>
                        <td>
                            {{ $activityImplementation->work_group->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.date') }}
                        </th>
                        <td>
                            {{ $activityImplementation->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.work_group') }}
                        </th>
                        <td>
                            {{ $activityImplementation->work_group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.potential') }}
                        </th>
                        <td>
                            {{ $activityImplementation->potential }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.problem') }}
                        </th>
                        <td>
                            {{ $activityImplementation->problem }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.activity') }}
                        </th>
                        <td>
                            {{ $activityImplementation->activity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.behavioral') }}
                        </th>
                        <td>
                            {{ $activityImplementation->behavioral }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.physical') }}
                        </th>
                        <td>
                            {{ $activityImplementation->physical }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.cost') }}
                        </th>
                        <td>
                            {{ $activityImplementation->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.partner') }}
                        </th>
                        <td>
                            {{ $activityImplementation->partner->name ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.activity-implementations.index') }}">
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
                <a class="nav-link" href="#activity_work_programs" role="tab" data-toggle="tab">
                    {{ trans('crud.workProgram.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="activity_work_programs">
                @includeIf('admin.activityImplementations.relationships.activityWorkPrograms', ['workPrograms' => $activityImplementation->activityWorkPrograms])
            </div>
        </div>
    </div>--}}

@endsection
