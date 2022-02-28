@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.disaster.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.disasters.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    {{--<tr>
                        <th>
                            {{ trans('crud.disaster.fields.threats') }}
                        </th>
                        <td>
                            @foreach($disaster->threats as $key => $threats)
                                --}}{{--<span class="label label-info">{{ $threats->name }}</span>--}}{{--

                                {{ $threats->name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </td>
                    </tr>--}}
                    <tr>
                        <th>
                            {{ trans('crud.disaster.fields.threat') }}
                        </th>
                        <td>
                            {{ $disaster->threat }}
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
                    <tr>
                        <th>
                            {{ trans('crud.disaster.fields.photo') }}
                        </th>
                        <td>
                            @if($disaster->photo)
                                <a href="{{ $disaster->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.disasters.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
