@extends('layouts.admin')
@section('content')
    {{--@can('activity_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.activity-implementations.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.activityImplementation.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.activityImplementation.title_singular') }}
        </div>

        <div class="card-body">
            <table
                class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ActivityImplementation">
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
                        {{ trans('crud.activityImplementation.fields.date') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.work_group') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.potential') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.problem') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.activity') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.behavioral') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.physical') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.cost') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.partner') }}
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
                @can('activity_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.activity-implementations.massDestroy') }}",
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
                    ajax: "{{ route('admin.activity-implementations.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'work_group_school_name', name: 'work_group.school.name'},
                        {data: 'date', name: 'date'},
                        {data: 'work_group_name', name: 'work_group.name'},
                        {data: 'potential', name: 'potential'},
                        {data: 'problem', name: 'problem'},
                        {data: 'activity', name: 'activity'},
                        {data: 'behavioral', name: 'behavioral'},
                        {data: 'physical', name: 'physical'},
                        {data: 'cost', name: 'cost'},
                        {data: 'partner_name', name: 'partner.name'},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-ActivityImplementation').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
