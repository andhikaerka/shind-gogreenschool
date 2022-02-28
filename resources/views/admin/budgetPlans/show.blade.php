@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.budgetPlan.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.budget-plans.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.budgetPlan.fields.school') }}
                        </th>
                        <td>
                            {{ $budgetPlan->school->name ?? '' }}
                        </td>
                    </tr>
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
                            {{ trans('crud.budgetPlan.fields.category') }}
                        </th>
                        <td>
                            {{ $snp_categories[$budgetPlan->category] ?? '' }}
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
                    <a class="btn btn-default" href="{{ route('admin.budget-plans.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
