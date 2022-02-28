@extends('layouts.admin')
@section('content')
    {{--@can('cadre_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.cadres.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.cadre.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.cadre.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Cadre">
                <thead>
                <tr>
                    <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                        {{ trans('crud.workGroup.fields.school') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.work_group') }}
                    </th>
                    <th>
                        {{ trans('crud.user.fields.name') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.gender') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.class') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.birth_date') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.address') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.hobby') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.position') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.photo') }}
                    </th>
                    <th>
                        {{ trans('crud.cadre.fields.letter') }}
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
                @can('cadre_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.cadres.massDestroy') }}",
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
                    ajax: "{{ route('admin.cadres.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'work_group_school_profile_school_name', name: 'work_group.school_profile.school.name'},
                        {data: 'work_group_work_group_name_name', name: 'work_group.work_group_name.name'},
                        {data: 'user_name', name: 'user.name'},
                        {data: 'gender', name: 'gender'},
                        {data: 'class', name: 'class'},
                        {data: 'phone', name: 'phone'},
                        {data: 'birth_date', name: 'birth_date'},
                        {data: 'address', name: 'address'},
                        {data: 'hobby', name: 'hobby'},
                        {data: 'position', name: 'position'},
                        {data: 'photo', name: 'photo', sortable: false, searchable: false},
                        {data: 'letter', name: 'letter', sortable: false, searchable: false},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-Cadre').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
