@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.disaster.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.disasters.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.disaster.fields.school') }}
                        </th>
                        <td>
                            {{ $disaster->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.disaster.fields.threats') }}
                        </th>
                        <td>
                            @foreach($disaster->threats as $key => $threats)
                                {{--<span class="label label-info">{{ $threats->name }}</span>--}}

                                {{ $threats->name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.disaster.fields.potential') }}
                        </th>
                        <td>
                            {{ $disaster->potential }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.disaster.fields.vulnerability') }}
                        </th>
                        <td>
                            {{ $disaster->vulnerability }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.disaster.fields.impact') }}
                        </th>
                        <td>
                            {{ $disaster->impact }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.disasters.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
