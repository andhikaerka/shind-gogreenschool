@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.team.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default"
                       href="{{ route('school.teams.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.name') }}
                        </th>
                        <td>
                            {{ $team->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.team_status') }}
                        </th>
                        <td>
                            {{ $team->team_status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Team::GENDER_SELECT[$team->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.birth_date') }}
                        </th>
                        <td>
                            {{ $team->birth_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.aspect') }}
                        </th>
                        <td>
                            {{ $team->work_group->aspect->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.work_group') }}
                        </th>
                        <td>
                            {{ $team->work_group->work_group_name->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.job_description') }}
                        </th>
                        <td>
                            {{ $team->job_description ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.team_position') }}
                        </th>
                        <td>
                            @if($team->team_position_id != 7)
                                {{ $team->team_position->name ?? '' }}
                            @else
                                {{ $team->another_position ?? '' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.document') }}
                        </th>
                        <td>
                            @if($team->document)
                                <a href="{{ $team->document->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.email') }}
                        </th>
                        <td>
                            {{ $team->user->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.username') }}
                        </th>
                        <td>
                            {{ $team->user->username ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default"
                       href="{{ route('school.teams.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
