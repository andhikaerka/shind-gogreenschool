@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            Akun Pengguna
        </div>

        <div class="card-body">
            <div class="form-group">
                {{--<div class="form-group">
                    <a class="btn btn-warning" href="{{ route('school.account.edit', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.edit') }}
                    </a>
                </div>--}}
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.name') }}
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.email') }}
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $user->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.username') }}
                        </th>
                        <td>
                            {{ $user->username }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled"
                                   {{ $user->approved ? 'checked' : '' }} title="{{ trans('crud.user.fields.approved') }}">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.roles') }}
                        </th>
                        <td>
                            @foreach($user->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-warning" href="{{ route('school.account.edit', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
