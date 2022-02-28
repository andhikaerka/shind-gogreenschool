@extends('layouts.admin')
@section('content')
    {{--@can('quality_report_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.quality-reports.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.qualityReport.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.qualityReport.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-QualityReport">
                <thead>
                <tr>
                    <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.school') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.has_document') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.document') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.waste_management') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.energy_conservation') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.life_preservation') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.water_conservation') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.canteen_management') }}
                    </th>
                    <th>
                        {{ trans('crud.qualityReport.fields.letter') }}
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
                @can('quality_report_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.quality-reports.massDestroy') }}",
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
                    ajax: "{{ route('admin.quality-reports.index') }}",
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                        {data: 'school_profile_school_name', name: 'school_profile.school.name'},
                        {data: 'has_document', name: 'has_document'},
                        {data: 'document', name: 'document', sortable: false, searchable: false},
                        {data: 'waste_management', name: 'waste_management'},
                        {data: 'energy_conservation', name: 'energy_conservation'},
                        {data: 'life_preservation', name: 'life_preservation'},
                        {data: 'water_conservation', name: 'water_conservation'},
                        {data: 'canteen_management', name: 'canteen_management'},
                        {data: 'letter', name: 'letter', sortable: false, searchable: false},
                        /*{data: 'actions', name: '{{ trans('global.actions') }}'}*/
                    ],
                    order: [[1, 'desc']],
                    pageLength: 10,
                };
            $('.datatable-QualityReport').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
