@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.infrastructure.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.infrastructures.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.infrastructure.fields.school') }}
                        </th>
                        <td>
                            {{ $infrastructure->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.infrastructure.fields.name') }}
                        </th>
                        <td>
                            {{ $infrastructure->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.infrastructure.fields.aspect') }}
                        </th>
                        <td>
                            {{ $infrastructure->aspect->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.infrastructure.fields.total') }}
                        </th>
                        <td>
                            {{ $infrastructure->total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.infrastructure.fields.function') }}
                        </th>
                        <td>
                            {{ $infrastructure->function }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.infrastructure.fields.photo') }}
                        </th>
                        <td>
                            @if($infrastructure->photo)
                                <a href="{{ $infrastructure->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.infrastructures.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
