@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.lessonPlan.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.lesson-plans.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.school') }}
                        </th>
                        <td>
                            {{ $lessonPlan->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.ktsp_or_rpp') }}
                        </th>
                        <td>
                            {{ App\LessonPlan::KTSP_OR_RPP_SELECT[$lessonPlan->ktsp_or_rpp] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.vision') }}
                        </th>
                        <td>
                            {{ $lessonPlan->vision }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.mission') }}
                        </th>
                        <td>
                            {{ $lessonPlan->mission }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.purpose') }}
                        </th>
                        <td>
                            {{ $lessonPlan->purpose }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.subject') }}
                        </th>
                        <td>
                            {{ $lessonPlan->subject }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.teacher') }}
                        </th>
                        <td>
                            {{ $lessonPlan->teacher }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.class') }}
                        </th>
                        <td>
                            {{ App\LessonPlan::CLASS_SELECT[$lessonPlan->class] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.aspect') }}
                        </th>
                        <td>
                            {{ $lessonPlan->aspect->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.hook') }}
                        </th>
                        <td>
                            {{ $lessonPlan->hook }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.artwork') }}
                        </th>
                        <td>
                            {{ $lessonPlan->artwork }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.hour') }}
                        </th>
                        <td>
                            {{ $lessonPlan->hour }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.period') }}
                        </th>
                        <td>
                            {{ App\LessonPlan::PERIOD_SELECT[$lessonPlan->period] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.syllabus') }}
                        </th>
                        <td>
                            @if($lessonPlan->syllabus)
                                <a href="{{ $lessonPlan->syllabus->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.rpp') }}
                        </th>
                        <td>
                            @if($lessonPlan->rpp)
                                <a href="{{ $lessonPlan->rpp->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.lessonPlan.fields.calendars') }}
                        </th>
                        <td>
                            @foreach($lessonPlan->calendars as $key => $calendars)
                                <span class="label label-info">{{ $calendars->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.lesson-plans.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
