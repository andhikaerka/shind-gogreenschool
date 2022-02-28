@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.workProgram.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.work-programs.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.workProgram.fields.work_group') }}
                        </th>
                        <td>
                            {{ $workProgram->work_group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workProgram.fields.study') }}
                        </th>
                        <td>
                            {{ $workProgram->study->potential ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workProgram.fields.condition') }}
                        </th>
                        <td>
                            {{ $workProgram->condition }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workProgram.fields.plan') }}
                        </th>
                        <td>
                            {{ $workProgram->plan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workProgram.fields.activity') }}
                        </th>
                        <td>
                            {!! $workProgram->study->activities ?? '' !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workProgram.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $workProgram->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.workProgram.fields.photo') }}
                        </th>
                        <td>
                            @if($workProgram->photo)
                                <a href="{{ $workProgram->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.work-programs.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
