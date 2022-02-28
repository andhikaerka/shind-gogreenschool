@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.activityImplementation.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.activity-implementations.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
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
                            {{ trans('crud.activity.fields.potential') }}
                        </th>
                        <td>
                            {{ $activityImplementation->activity->potential ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.progress') }}
                        </th>
                        <td>
                            {{ $activityImplementation->progress }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.constraints') }}
                        </th>
                        <td>
                            {{ $activityImplementation->constraints }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.plan') }}
                        </th>
                        <td>
                            {{ $activityImplementation->plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.activityImplementation.fields.document') }}
                        </th>
                        <td>
                            {{ $activityImplementation->document }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.activity-implementations.index', ['school_slug' => $school_slug]) }}">
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
                @includeIf('school.activityImplementations.relationships.activityWorkPrograms', ['workPrograms' => $activityImplementation->activityWorkPrograms])
            </div>
        </div>
    </div>--}}

@endsection
