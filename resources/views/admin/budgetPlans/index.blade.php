@extends('layouts.admin')
@section('content')
    {{--@can('budget_plan_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.budget-plans.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.budgetPlan.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.budgetPlan.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-BudgetPlan">
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
                    {{--<th>
                        {{ trans('global.action') }}
                    </th>--}}
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('budget_plan_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.budget-plans.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    const ids = $.map(dt.rows({selected: true}).data(), function (entry) {
                        return entry.id
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

            let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    ajax: "{{ route('admin.budget-plans.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'school_profile_school_name', name: 'school_profile.school.name'},
                        {data: 'aspect_id', name: 'aspect_id'},
                        {data: 'description', name: 'description'},
                        {data: 'cost', name: 'cost'},
                        {data: 'category', name: 'category'},
                        {data: 'source', name: 'source'},
                        {data: 'pic', name: 'pic'},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-BudgetPlan').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
