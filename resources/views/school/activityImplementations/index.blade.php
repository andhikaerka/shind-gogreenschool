@extends('layouts.school')

@section('title')
    {{ trans('global.list') }} {{ trans('crud.activityImplementation.title_singular') }} - {{ trans('panel.site_title') }}
@endsection

@section('content')
    @if($school_slug == auth()->user()->school_slug)
        @can('activity_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success"
                       href="{{ route("school.activity-implementations.create", ['school_slug' => $school_slug]) }}">
                        {{ trans('global.add') }} {{ trans('crud.activityImplementation.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
    @endif
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
                        {{ trans('crud.activityImplementation.fields.date') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.work_group') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.activity') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.progress') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.constraints') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.plan') }}
                    </th>
                    <th>
                        {{ trans('crud.activityImplementation.fields.document') }}
                    </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
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
            @if($school_slug == auth()->user()->school_slug)
            @can('activity_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('school.activity-implementations.massDestroy', ['school_slug' => $school_slug]) }}",
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
            @endif

            let dtOverrideGlobals = {
                dom: "<'row'<'col-sm-12 mb-sm-3'B>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('school.activity-implementations.index', ['school_slug' => $school_slug]) }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                    {data: 'date', name: 'date'},
                    {data: 'work_group_name', name: 'work_group.name'},
                    {data: 'activity_potential', name: 'activity.potential'},
                    {data: 'progress', name: 'progress'},
                    {data: 'constraints', name: 'constraints'},
                    {data: 'plan', name: 'plan'},
                    {data: 'document', name: 'document'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
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
