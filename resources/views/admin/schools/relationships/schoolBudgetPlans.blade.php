<div class="m-3">
    @can('budget_plan_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.budget-plans.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.budgetPlan.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.budgetPlan.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-schoolBudgetPlans">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.budgetPlan.fields.school') }}
                        </th>
                        <th>
                            {{ trans('crud.budgetPlan.fields.aspect') }}
                        </th>
                        <th>
                            {{ trans('crud.budgetPlan.fields.description') }}
                        </th>
                        <th>
                            {{ trans('crud.budgetPlan.fields.cost') }}
                        </th>
                        <th>
                            {{ trans('crud.budgetPlan.fields.category') }}
                        </th>
                        <th>
                            {{ trans('crud.budgetPlan.fields.source') }}
                        </th>
                        <th>
                            {{ trans('crud.budgetPlan.fields.pic') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($budgetPlans as $key => $budgetPlan)
                        <tr data-entry-id="{{ $budgetPlan->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $budgetPlan->school->name ?? '' }}
                            </td>
                            <td>
                                {{ App\BudgetPlan::TOPIC_SELECT[$budgetPlan->aspect_id] ?? '' }}
                            </td>
                            <td>
                                {{ $budgetPlan->description ?? '' }}
                            </td>
                            <td>
                                {{ $budgetPlan->cost ?? '' }}
                            </td>
                            <td>
                                {{ $snp_categories[$budgetPlan->category] ?? '' }}
                            </td>
                            <td>
                                {{ App\BudgetPlan::SOURCE_SELECT[$budgetPlan->source] ?? '' }}
                            </td>
                            <td>
                                {{ $budgetPlan->pic ?? '' }}
                            </td>
                            <td>
                                @can('budget_plan_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.budget-plans.show', $budgetPlan->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('budget_plan_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.budget-plans.edit', $budgetPlan->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('budget_plan_delete')
                                    <form action="{{ route('admin.budget-plans.destroy', $budgetPlan->id) }}"
                                          method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('budget_plan_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.budget-plans.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 10,
            });
            $('.datatable-schoolBudgetPlans:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
