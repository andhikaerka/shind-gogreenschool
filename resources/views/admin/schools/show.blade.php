@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.school.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">

                <div class="form-group">
                    @can('school_access')
                        <a class="btn btn-default" href="{{ route('admin.schools.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    @endcan
                    @can('school_edit')
                        <a class="btn btn-info"
                           href="{{ route('admin.schools.edit', $school->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                    @endcan
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.name') }}
                        </th>
                        <td>
                            {{ $school->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.level') }}
                        </th>
                        <td>
                            {{ App\School::LEVEL_SELECT[$school->level] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.vision') }}
                        </th>
                        <td>
                            {{ $school->vision }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.status') }}
                        </th>
                        <td>
                            {{ App\School::STATUS_SELECT[$school->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.address') }}
                        </th>
                        <td>
                            {{ $school->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.city') }}
                        </th>
                        <td>
                            {{ $school->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.city.fields.province') }}
                        </th>
                        <td>
                            {{ $school->city->province->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.phone') }}
                        </th>
                        <td>
                            {{ $school->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.email') }}
                        </th>
                        <td>
                            {{ $school->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_students') }}
                        </th>
                        <td>
                            {{ $school->total_students }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_teachers') }}
                        </th>
                        <td>
                            {{ $school->total_teachers }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_land_area') }}
                        </th>
                        <td>
                            {{ $school->total_land_area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_building_area') }}
                        </th>
                        <td>
                            {{ $school->total_building_area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.logo') }}
                        </th>
                        <td>
                            @if($school->logo)
                                <a href="{{ $school->logo->getUrl() }}" target="_blank">
                                    <img src="{{ $school->logo->getUrl() }}" width="50px" height="50px" alt="">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.photo') }}
                        </th>
                        <td>
                            @if($school->photo)
                                <a href="{{ $school->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled"
                                   {{ $school->user->approved ? 'checked' : '' }} title="{{ trans('crud.user.fields.approved') }}">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="form-group">
                    @can('school_access')
                        <a class="btn btn-default" href="{{ route('admin.schools.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    @endcan
                    @can('school_edit')
                        <a class="btn btn-info"
                           href="{{ route('admin.schools.edit', $school->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                    @endcan
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
                <a class="nav-link" href="#school_infrastructures" role="tab" data-toggle="tab">
                    {{ trans('crud.infrastructure.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#school_disasters" role="tab" data-toggle="tab">
                    {{ trans('crud.disaster.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#school_quality_reports" role="tab" data-toggle="tab">
                    {{ trans('crud.qualityReport.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#school_teams" role="tab" data-toggle="tab">
                    {{ trans('crud.team.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#school_partners" role="tab" data-toggle="tab">
                    {{ trans('crud.partner.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#school_work_groups" role="tab" data-toggle="tab">
                    {{ trans('crud.workGroup.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#school_budget_plans" role="tab" data-toggle="tab">
                    {{ trans('crud.budgetPlan.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#school_lesson_plans" role="tab" data-toggle="tab">
                    {{ trans('crud.lessonPlan.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="school_infrastructures">
                @includeIf('admin.schools.relationships.schoolInfrastructures', ['infrastructures' => $school->schoolInfrastructures])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_disasters">
                @includeIf('admin.schools.relationships.schoolDisasters', ['disasters' => $school->schoolDisasters])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_quality_reports">
                @includeIf('admin.schools.relationships.schoolQualityReports', ['qualityReports' => $school->schoolQualityReports])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_teams">
                @includeIf('admin.schools.relationships.schoolTeams', ['teams' => $school->schoolTeams])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_partners">
                @includeIf('admin.schools.relationships.schoolPartners', ['partners' => $school->schoolPartners])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_work_groups">
                @includeIf('admin.schools.relationships.schoolWorkGroups', ['workGroups' => $school->schoolWorkGroups])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_budget_plans">
                @includeIf('admin.schools.relationships.schoolBudgetPlans', ['budgetPlans' => $school->schoolBudgetPlans])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_lesson_plans">
                @includeIf('admin.schools.relationships.schoolLessonPlans', ['lessonPlans' => $school->schoolLessonPlans])
            </div>
        </div>
    </div>--}}

@endsection
