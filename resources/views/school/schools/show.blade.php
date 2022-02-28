@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.school.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">

                <form action="" method="get" class="mb-3">
                    <div class="row form-row">
                        <div class="col mr-sm-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="required input-group-text bg-transparent border-0"
                                           for="year">{{ trans('crud.schoolProfile.fields.year') }} :</label>
                                </div>
                                <input
                                    class="form-control year rounded-left {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                    type="text" name="year" autocomplete="off"
                                    id="year" value="{{ request()->get('year', date('Y')) }}"
                                    minlength="4" maxlength="4" data-toggle="datetimepicker" data-target="#year"
                                    required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        {{ trans('global.view') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                <a href="{{ route('school.print', $school_slug) }}" target="_blank" id="btnPrint" class="btn btn-outline-success" type="button">
                    {{ trans('global.datatables.print') }}
                </a>
                        <div class="col mr-sm-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-0">Kondisi {{ trans('crud.school.title') }} :</span>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent border-0"
                                         id="recordsTotal">{{ $schoolProfile->schoolProfileScore['condition'] ?? null }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text bg-transparent border-0">Skor :</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text bg-transparent border-0"
                                         id="recordsScore">{{ $schoolProfile->schoolProfileScore['score'] ?? null }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

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
                            {{ $schoolProfile->vision ?? '' }}
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
                            {{ trans('crud.school.fields.website') }}
                        </th>
                        <td>
                            {{ $school->website }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_students') }}
                        </th>
                        <td>
                            {{ isset($schoolProfile->total_students) ? number_format($schoolProfile->total_students, 0, ',', '.') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_teachers') }}
                        </th>
                        <td>
                            {{ isset($schoolProfile->total_teachers) ? number_format($schoolProfile->total_teachers, 0, ',', '.') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_land_area') }}
                        </th>
                        <td>
                            {!! isset($schoolProfile->total_land_area) ? number_format($schoolProfile->total_land_area, 0, ',', '.').' &#13217;' : '' !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_building_area') }}
                        </th>
                        <td>
                            {!! isset($schoolProfile->total_building_area) ? number_format($schoolProfile->total_building_area, 0, ',', '.').' &#13217;' : '' !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.logo') }}
                        </th>
                        <td>
                            @if(isset($school->logo))
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
                            @if(isset($schoolProfile->photo))
                                <a href="{{ $schoolProfile->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                @if($school_slug == auth()->user()->school_slug)
                    <div class="form-group">
                        @can('school_edit')
                            <a class="btn btn-info"
                               href="{{ route('school.edit', ['school_slug' => $school->slug, 'year' => request()->get('year', date('Y'))]) }}">
                                {{ trans('global.edit') }}
                            </a>
                        @endcan
                    </div>
                @endif

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
                @includeIf('school.schools.relationships.schoolInfrastructures', ['infrastructures' => $school->schoolInfrastructures])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_disasters">
                @includeIf('school.schools.relationships.schoolDisasters', ['disasters' => $school->schoolDisasters])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_quality_reports">
                @includeIf('school.schools.relationships.schoolQualityReports', ['qualityReports' => $school->schoolQualityReports])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_teams">
                @includeIf('school.schools.relationships.schoolTeams', ['teams' => $school->schoolTeams])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_partners">
                @includeIf('school.schools.relationships.schoolPartners', ['partners' => $school->schoolPartners])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_work_groups">
                @includeIf('school.schools.relationships.schoolWorkGroups', ['workGroups' => $school->schoolWorkGroups])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_budget_plans">
                @includeIf('school.schools.relationships.schoolBudgetPlans', ['budgetPlans' => $school->schoolBudgetPlans])
            </div>
            <div class="tab-pane" role="tabpanel" id="school_lesson_plans">
                @includeIf('school.schools.relationships.schoolLessonPlans', ['lessonPlans' => $school->schoolLessonPlans])
            </div>
        </div>
    </div>--}}

@endsection
@section('scripts')
@endsection
