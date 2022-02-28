@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.recommendation.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.recommendations.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.date') }}
                        </th>
                        <td>
                            {{ $recommendation->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.cadre_activity') }}
                        </th>
                        <td>
                            {{ $recommendation->cadre_activity->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.potential') }}
                        </th>
                        <td>
                            {{ $recommendation->potential }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.problem') }}
                        </th>
                        <td>
                            {{ $recommendation->problem }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.recommendation') }}
                        </th>
                        <td>
                            {{ $recommendation->recommendation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.behavioral') }}
                        </th>
                        <td>
                            {{ $recommendation->behavioral }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.physical') }}
                        </th>
                        <td>
                            {{ $recommendation->physical }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.cost') }}
                        </th>
                        <td>
                            {{ $recommendation->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.recommendation.fields.partner') }}
                        </th>
                        <td>
                            {{ $recommendation->partner->name ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.recommendations.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
