@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.activity.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.activities.index') }}">
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
                            {{ $activity->work_group->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.date') }}
                        </th>
                        <td>
                            {{ $activity->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.work_group') }}
                        </th>
                        <td>
                            {{ $activity->work_group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.potential') }}
                        </th>
                        <td>
                            {{ $activity->potential }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.problem') }}
                        </th>
                        <td>
                            {{ $activity->problem }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.activity') }}
                        </th>
                        <td>
                            {{ $activity->activity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.behavioral') }}
                        </th>
                        <td>
                            {{ $activity->behavioral }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.physical') }}
                        </th>
                        <td>
                            {{ $activity->physical }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.cost') }}
                        </th>
                        <td>
                            {{ $activity->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activity.fields.partner') }}
                        </th>
                        <td>
                            {{ $activity->partner->name ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.activities.index') }}">
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
                @includeIf('admin.activities.relationships.activityWorkPrograms', ['workPrograms' => $activity->activityWorkPrograms])
            </div>
        </div>
    </div>--}}

@endsection
