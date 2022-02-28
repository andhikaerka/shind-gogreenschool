@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.cadreActivity.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.date') }}
                        </th>
                        <td>
                            {{ $cadreActivity->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.work_program') }}
                        </th>
                        <td>
                            {{ $cadreActivity->work_program->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.potential') }}
                        </th>
                        <td>
                            {{ $cadreActivity->potential }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.problem') }}
                        </th>
                        <td>
                            {{ $cadreActivity->problem }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.activity') }}
                        </th>
                        <td>
                            {{ $cadreActivity->activity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.behavioral') }}
                        </th>
                        <td>
                            {{ $cadreActivity->behavioral }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.physical') }}
                        </th>
                        <td>
                            {{ $cadreActivity->physical }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.cost') }}
                        </th>
                        <td>
                            {{ $cadreActivity->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadreActivity.fields.team_status') }}
                        </th>
                        <td>
                            {{ $cadreActivity->team_status->name ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
