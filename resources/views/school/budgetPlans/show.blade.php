@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.budgetPlan.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.budget-plans.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.budgetPlan.fields.aspect') }}
                        </th>
                        <td>
                            {{ App\BudgetPlan::TOPIC_SELECT[$budgetPlan->aspect_id] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.budgetPlan.fields.description') }}
                        </th>
                        <td>
                            {{ $budgetPlan->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.budgetPlan.fields.cost') }}
                        </th>
                        <td>
                            {{ $budgetPlan->cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.budgetPlan.fields.snp_category') }}
                        </th>
                        <td>
                            {{ $budgetPlan->snp_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.budgetPlan.fields.source') }}
                        </th>
                        <td>
                            {{ App\BudgetPlan::SOURCE_SELECT[$budgetPlan->source] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.budgetPlan.fields.pic') }}
                        </th>
                        <td>
                            {{ $budgetPlan->pic }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.budget-plans.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
