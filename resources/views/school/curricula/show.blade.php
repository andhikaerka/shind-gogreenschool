@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.curriculum.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.curricula.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.ktsp_or_rpp') }}
                        </th>
                        <td>
                            {{ App\Curriculum::KTSP_OR_RPP_SELECT[$curriculum->ktsp_or_rpp] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.vision') }}
                        </th>
                        <td>
                            {{ $curriculum->vision }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.mission') }}
                        </th>
                        <td>
                            {{ $curriculum->mission }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.purpose') }}
                        </th>
                        <td>
                            {{ $curriculum->purpose }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.subject') }}
                        </th>
                        <td>
                            {{ $curriculum->subject }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.teacher') }}
                        </th>
                        <td>
                            {{ $curriculum->teacher }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.class') }}
                        </th>
                        <td>
                            {{ App\Curriculum::CLASS_SELECT[$curriculum->class] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.aspect') }}
                        </th>
                        <td>
                            {{ $curriculum->aspect->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.hook') }}
                        </th>
                        <td>
                            {{ $curriculum->hook }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.artwork') }}
                        </th>
                        <td>
                            {{ $curriculum->artwork }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.hour') }}
                        </th>
                        <td>
                            {{ $curriculum->hour }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.period') }}
                        </th>
                        <td>
                            {{ App\Curriculum::PERIOD_SELECT[$curriculum->period] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.syllabus') }}
                        </th>
                        <td>
                            @if($curriculum->syllabus)
                                <a href="{{ $curriculum->syllabus->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.rpp') }}
                        </th>
                        <td>
                            @if($curriculum->rpp)
                                <a href="{{ $curriculum->rpp->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.curriculum.fields.calendars') }}
                        </th>
                        <td>
                            @foreach($curriculum->calendars as $key => $calendars)
                                <span class="label label-info">{{ $calendars->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.curricula.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
