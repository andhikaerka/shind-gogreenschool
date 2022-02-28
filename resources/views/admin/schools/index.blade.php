@extends('layouts.admin')
@section('content')
    {{--@can('school_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.schools.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.school.title_singular') }}
                </a>
            </div>
        </div>
    @endcan--}}
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.school.title_singular') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-School">
                <thead>
                <tr>
                    <th style="width: 10px;" rowspan="2">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th rowspan="2">
                        No
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.name') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.environmental_status') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.level') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.vision') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.status') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.address') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.city') }}
                    </th>

                    <th rowspan="2">
                        {{ trans('crud.city.fields.province') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.phone') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.email') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.total_students') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.total_teachers') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.total_land_area') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.total_building_area') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.logo') }}
                    </th>
                    <th rowspan="2">
                        {{ trans('crud.school.fields.photo') }}
                    </th>
                    <th colspan="2">
                        Approvel Waktu
                    </th>
                    <th rowspan="2">
                        {{ trans('global.action') }}
                    </th>
                </tr>
                <tr>
                    <th>Kondisi</th>
                    <th>Waktu</th>
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
            @can('school_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.schools.massDestroy') }}",
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
                dom: "<'row'<'col-sm-12 mb-sm-3'B>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: dtButtons,
                responsive: true,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.schools.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false, printable: false },
                    {data: 'name', name: 'name'},
                    {data: 'environmental_status_name', name: 'schoolSchoolProfiles.environmental_status.name'},
                    {data: 'level', name: 'level'},
                    {data: 'vision', name: 'schoolSchoolProfiles.vision'},
                    {data: 'status', name: 'status'},
                    {data: 'address', name: 'address'},
                    {data: 'city_name', name: 'city.name'},
                    {data: 'city_province_name', name: 'city.province.name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'total_students', name: 'schoolSchoolProfiles.total_students'},
                    {data: 'total_teachers', name: 'schoolSchoolProfiles.total_teachers'},
                    {data: 'total_land_area', name: 'schoolSchoolProfiles.total_land_area'},
                    {data: 'total_building_area', name: 'schoolSchoolProfiles.total_building_area'},
                    {data: 'logo', name: 'logo', sortable: false, searchable: false},
                    {data: 'photo', name: 'photo', sortable: false, searchable: false},
                    {data: 'approval_condition', name: 'approval_condition'},
                    {data: 'approval_time', name: 'approval_time'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                order: [[1, 'desc']],
                pageLength: 10,
            };
            $('.datatable-School').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
