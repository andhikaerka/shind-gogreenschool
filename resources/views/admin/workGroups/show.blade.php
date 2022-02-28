@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.workGroup.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.work-groups.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.workGroup.fields.school') }}
                        </th>
                        <td>
                            {{ $workGroup->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.schoolProfile.fields.year') }}
                        </th>
                        <td>
                            {{ $workGroup->year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workGroup.fields.name') }}
                        </th>
                        <td>
                            {{ $workGroup->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workGroup.fields.tutor_1') }}
                        </th>
                        <td>
                            {{ $workGroup->tutor_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workGroup.fields.tutor_2') }}
                        </th>
                        <td>
                            {{ $workGroup->tutor_2 }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.work-groups.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#work_group_cadres" role="tab" data-toggle="tab">
                    {{ trans('crud.cadre.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#work_group_work_programs" role="tab" data-toggle="tab">
                    {{ trans('crud.workProgram.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#work_group_studies" role="tab" data-toggle="tab">
                    {{ trans('crud.study.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="work_group_cadres">
                @includeIf('admin.workGroups.relationships.workGroupCadres', ['cadres' => $workGroup->workGroupCadres])
            </div>
            <div class="tab-pane" role="tabpanel" id="work_group_work_programs">
                @includeIf('admin.workGroups.relationships.workGroupWorkPrograms', ['workPrograms' => $workGroup->workGroupWorkPrograms])
            </div>
            <div class="tab-pane" role="tabpanel" id="work_group_studies">
                @includeIf('admin.workGroups.relationships.workGroupStudies', ['studies' => $workGroup->workGroupStudies])
            </div>
        </div>
    </div>

@endsection
