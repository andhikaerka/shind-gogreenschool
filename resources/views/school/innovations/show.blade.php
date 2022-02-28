@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.innovation.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.innovations.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.innovation.fields.work_group') }}
                        </th>
                        <td>
                            {{ $innovation->work_group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.innovation.fields.study') }}
                        </th>
                        <td>
                            {{ $innovation->study->potential ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.innovation.fields.condition') }}
                        </th>
                        <td>
                            {{ $innovation->condition }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.innovation.fields.plan') }}
                        </th>
                        <td>
                            {{ $innovation->plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.innovation.fields.activity') }}
                        </th>
                        <td>
                            {{ $innovation->activity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.innovation.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $innovation->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.innovation.fields.photo') }}
                        </th>
                        <td>
                            @if($innovation->photo)
                                <a href="{{ $innovation->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.innovations.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
