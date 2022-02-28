@extends('layouts.admin')
@section('content')
    {{--@can('work_program_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.work-programs.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.workProgram.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.workProgram.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-WorkProgram">
                <thead>
                <tr>
                    <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                        {{ trans('crud.workProgram.fields.work_group') }}
                    </th>
                    <th>
                        {{ trans('crud.workProgram.fields.study') }}
                    </th>
                    <th>
                        {{ trans('crud.workProgram.fields.condition') }}
                    </th>
                    <th>
                        {{ trans('crud.workProgram.fields.plan') }}
                    </th>
                    <th>
                        {{ trans('crud.workProgram.fields.activity') }}
                    </th>
                    <th>
                        {{ trans('crud.workProgram.fields.featured') }}
                    </th>
                    <th>
                        {{ trans('crud.workProgram.fields.photo') }}
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
                @can('work_program_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.work-programs.massDestroy') }}",
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
                    ajax: "{{ route('admin.work-programs.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'study_work_group_school_profile_school_name', name: 'study.work_group.school_profile.school.name'},
                        {data: 'study_potential', name: 'study.potential'},
                        {data: 'condition', name: 'condition'},
                        {data: 'plan', name: 'plan'},
                        {data: 'study_activity', name: 'study.activity'},
                        {data: 'featured', name: 'featured'},
                        {data: 'photo', name: 'photo', sortable: false, searchable: false},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-WorkProgram').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
