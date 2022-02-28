@extends('layouts.school')

@section('title')
    {{ trans('global.list') }} {{ trans('crud.infrastructure.title_singular') }} - {{ trans('panel.site_title') }}
@endsection

@section('content')
    @if($school_slug == auth()->user()->school_slug)
        @can('infrastructure_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success"
                       href="{{ route("school.infrastructures.create", ['school_slug' => $school_slug, 'year' => request()->input('year')]) }}">
                        {{ trans('global.add') }} {{ trans('crud.infrastructure.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
    @endif
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.infrastructure.title_singular') }}
        </div>

        <div class="card-body">
            <form action="" method="get" class="mb-3">
                <div class="row form-row">
                    <div class="col mr-sm-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="required input-group-text bg-transparent border-0"
                                       for="year">{{ trans('crud.schoolProfile.fields.year') }}&nbsp;:</label>
                            </div>
                            <input
                                class="form-control year rounded-left {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                type="text" name="year" autocomplete="off"
                                id="year" value="{{ request()->get('year', date('Y')) }}"
                                minlength="4" maxlength="4" data-toggle="datetimepicker" data-target="#year" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    {{ trans('global.view') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col mr-sm-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0">Kondisi {{ trans('crud.infrastructure.title') }}&nbsp;:</span>
                            </div>
                            <div class="input-group-append">
                                <div class="input-group-text bg-transparent border-0" id="recordsCondition"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text bg-transparent border-0">Skor&nbsp;:</label>
                            </div>
                            <div class="input-group-append">
                                <div class="input-group-text bg-transparent border-0" id="recordsScore"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

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
                        {{ trans('crud.infrastructure.fields.name') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.aspect') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.work_group') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.total') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.function') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.pic') }}
                    </th>
                    <th>
                        {{ trans('crud.infrastructure.fields.photo') }}
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
            @can('infrastructure_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('school.infrastructures.massDestroy', ['school_slug' => $school_slug]) }}",
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
                ajax: {
                    url: "{{ route('school.infrastructures.index', ['school_slug' => $school_slug]) }}",
                    data: {
                        year: "{{ request()->get('year', date('Y')) }}"
                    }
                },
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'aspect_name', name: 'aspect.name'},
                    {data: 'work_group_work_group_name_name', name: 'work_group.work_group_name.name'},
                    {data: 'total', name: 'total'},
                    {data: 'function', name: 'function'},
                    {data: 'pic', name: 'pic'},
                    {data: 'photo', name: 'photo', sortable: false, searchable: false},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                order: [[1, 'desc']],
                pageLength: 10,
                initComplete: function (settings, json) {
                    $('div#recordsScore').text(json.score)
                    $('div#recordsCondition').text(json.condition)
                }
            };
            $('.datatable-Infrastructure').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
