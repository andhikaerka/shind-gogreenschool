@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.team.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.school') }}
                        </th>
                        <td>
                            {{ $team->school->name ?? '' }}
                        </td>
                    </tr>
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
                            {{ trans('crud.team.fields.status') }}
                        </th>
                        <td>
                            {{ App\Team::STATUS_SELECT[$team->status] ?? '' }}
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
                            {{ App\Team::SECTOR_SELECT[$team->aspect_id] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.team.fields.position') }}
                        </th>
                        <td>
                            {{ App\Team::POSITION_SELECT[$team->position] ?? '' }}
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
                    <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
