@extends('layouts.admin')
@section('content')
    {{--@can('team_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.teams.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.team.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.team.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Team">
                <thead>
                <tr>
                    <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                        {{ trans('crud.team.fields.school') }}
                    </th>
                    <th>
                        {{ trans('crud.team.fields.name') }}
                    </th>
                    <th>
                        {{ trans('crud.team.fields.status') }}
                    </th>
                    <th>
                        {{ trans('crud.team.fields.gender') }}
                    </th>
                    <th>
                        {{ trans('crud.team.fields.birth_date') }}
                    </th>
                    <th>
                        {{ trans('crud.team.fields.aspect') }}
                    </th>
                    <th>
                        {{ trans('crud.team.fields.position') }}
                    </th>
                    <th>
                        {{ trans('crud.team.fields.document') }}
                    </th>
                   {{-- <th>
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
                @can('team_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.teams.massDestroy') }}",
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
                    ajax: "{{ route('admin.teams.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'work_group_school_profile_school_name', name: 'work_group.school_profile.school.name'},
                        {data: 'name', name: 'name'},
                        {data: 'team_status_name', name: 'team_status.name'},
                        {data: 'gender', name: 'gender'},
                        {data: 'birth_date', name: 'birth_date'},
                        {data: 'aspect_id', name: 'aspect_id'},
                        {data: 'team_position_name', name: 'team_position.name'},
                        {data: 'document', name: 'document', sortable: false, searchable: false},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-Team').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
