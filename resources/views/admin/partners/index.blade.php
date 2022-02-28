@extends('layouts.admin')
@section('content')
    {{--@can('partner_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.partners.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.partner.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.partner.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Partner">
                <thead>
                <tr>
                    <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.school') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.name') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.category') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.activity') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.date') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.purpose') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.total_people') }}
                    </th>
                    <th>
                        {{ trans('crud.partner.fields.photo') }}
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
                @can('partner_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.partners.massDestroy') }}",
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
                    ajax: "{{ route('admin.partners.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'school_profile_school_name', name: 'school_profile.school.name'},
                        {data: 'name', name: 'name'},
                        {data: 'cp_phone', name: 'cp_phone'},
                        {data: 'partner_category_name', name: 'partner_category.name'},
                        {data: 'partner_activity_name', name: 'partner_activity.name'},
                        {data: 'date', name: 'date'},
                        {data: 'purpose', name: 'purpose'},
                        {data: 'total_people', name: 'total_people'},
                        {data: 'photo', name: 'photo', sortable: false, searchable: false},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-Partner').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
