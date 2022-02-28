@extends('layouts.school')

@section('title')
    {{ trans('global.list') }} {{ trans('crud.cadreActivity.title_singular') }} - {{ trans('panel.site_title') }}
@endsection

@section('content')
    @if(auth()->check() && ($school_slug == auth()->user()->school_slug || auth()->user()->isAdmin))
        @can('activity_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success"
                       href="{{ route("school.cadre-activities.create", ['school_slug' => $school_slug, 'year' => request()->input('year')]) }}">
                        {{ trans('global.add') }} {{ trans('crud.cadreActivity.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
    @endif
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.cadreActivity.title_singular') }}
        </div>

        <div class="card-body">
            <form action="" method="get" class="mb-3">
                <div class="row form-row">{{--
                    <div class="col mr-sm-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="required input-group-text bg-transparent border-0"
                                       for="work_group_name_id">{{ trans('crud.workGroup.fields.work_group_name') }}&nbsp;:</label>
                            </div>
                            <select class="form-control select2 {{ $errors->has('work_group_name_id') ? 'is-invalid' : '' }}"
                                    name="work_group_name_id" id="work_group_name_id">
                                <option value="">Semua</option>
                                @foreach(\App\WorkGroupName::all() as $id => $workGroupName)
                                    <option
                                        value="{{ $workGroupName->id }}" {{ request()->get('work_group_name_id') == $workGroupName->id ? 'selected' : '' }}>{{ $workGroupName->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="required input-group-text bg-transparent border-0"
                                       for="aspect_id">Nama Aspek&nbsp;:</label>
                            </div>
                            <select class="form-control select2 {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}"
                                    name="aspect_id" id="aspect_id">
                                <option value="">Semua</option>
                                @foreach(\App\Aspect::all() as $id => $workGroupName)
                                    <option
                                        value="{{ $workGroupName->id }}" {{ request()->get('aspect_id') == $workGroupName->id ? 'selected' : '' }}>{{ $workGroupName->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
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
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0">Kondisi {{ trans('crud.cadreActivity.title') }}&nbsp;:</span>
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

            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Activity">
                <thead>
                <tr>
                    <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.date') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.work_group') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.work_program') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.self_development') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.condition') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.results') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.problem') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.behavioral') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.physical') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.plan') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.team_statuses') }}
                    </th>
                    <th style="white-space: normal;">
                        {{ trans('crud.cadreActivity.fields.tutor') }}
                    </th>
                    <th>
                        {{ trans('crud.cadreActivity.fields.document') }}
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
                url: "{{ route('school.cadre-activities.massDestroy', ['school_slug' => $school_slug]) }}",
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
                responsive: true,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: {
                    url: "{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}",
                    data: {
                        work_group_name_id: "{{ request()->get('work_group_name_id') }}",
                        year: "{{ request()->get('year', date('Y')) }}",
                    }
                },
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                    {data: 'date', name: 'date'},
                    {data: 'work_program_study_work_group_work_group_name_name', name: 'work_program.study.work_group.work_group_name.name'},
                    {data: 'work_program_plan', name: 'work_program.plan'},
                    {data: 'self_development', name: 'self_development'},
                    {data: 'condition', name: 'condition'},
                    {data: 'results', name: 'results'},
                    {data: 'problem', name: 'problem'},
                    {data: 'behavioral', name: 'behavioral'},
                    {data: 'physical', name: 'physical'},
                    {data: 'plan', name: 'plan'},
                    {data: 'team_statuses_name', name: 'team_statuses.name'},
                    {data: 'work_program_tutor', name: 'work_program.tutor_1', className: 'white-space-pre'},
                    {data: 'document', name: 'work_program.document'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                order: [[1, 'desc']],
                pageLength: 10,
                initComplete: function (settings, json) {
                    $('div#recordsScore').text(json.score)
                    $('div#recordsCondition').text(json.condition)
                }
            };
            $('.datatable-Activity').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
