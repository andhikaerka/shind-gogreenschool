@extends('layouts.admin')

@section('title', trans('crud.infrastructure.title_singular'))
@section('content-header', trans('crud.infrastructure.title_singular'))

@section('content')
    {{--@can('infrastructure_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.infrastructures.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.infrastructure.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.infrastructure.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Infrastructure">
                <thead>
                <tr>
                    <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.school') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.name') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.aspect') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.total') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.function') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.photo') }}
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
                @can('infrastructure_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.infrastructures.massDestroy') }}",
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
                    ajax: "{{ route('admin.infrastructures.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'work_group_school_profile_school_name', name: 'work_group.school_profile.school.name'},
                        {data: 'name', name: 'name'},
                        {data: 'aspect_name', name: 'aspect.name'},
                        {data: 'total', name: 'total'},
                        {data: 'function', name: 'function'},
                        {data: 'photo', name: 'photo', sortable: false, searchable: false},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-Infrastructure').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
