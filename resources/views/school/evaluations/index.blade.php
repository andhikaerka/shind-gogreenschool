@extends('layouts.school')

@section('title')
    {{ trans('global.list') }} {{ trans('crud.evaluation.title_singular') }} - {{ trans('panel.site_title') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('crud.evaluation.title') }}
        </div>

        <div class="card-body">
            <form id="formPrint" action="" method="get" class="mb-3 form-inline">
                <div class="form-group">
                    <label class="required my-1 mr-2"
                           for="aspect_id">{{ trans('crud.workGroup.fields.aspect') }}</label>
                    <select class="form-control my-1 mr-sm-3 {{ $errors->has('aspect') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id" required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', request()->get('aspect_id')) == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect'))
                        <span class="text-danger">{{ $errors->first('aspect') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required my-1 mr-2" for="work_group_id">Kelompok Kerja Kader</label>
                    <select
                        class="form-control my-1 mr-sm-3 select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                        disabled name="work_group_id" id="work_group_id" required>
                        <option value
                                disabled {{ old('work_group_id', request()->get('work_group_id') ) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                </div>

                <div class="input-group my-1 mr-sm-3">
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
                        <button id="btnView" class="btn btn-outline-secondary" type="button">
                            {{ trans('global.view') }}
                        </button>
                    </div>
                </div>

                {{--<button id="btnPrint" class="btn btn-outline-success" type="button">
                    {{ trans('global.datatables.print') }}
                </button>--}}
            </form>

            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Activity">
                    <thead>
                    <tr>
                        <th rowspan="2">
                            No
                        </th>
                        <th rowspan="2">
                            Nama Kegiatan
                        </th>
                        <th colspan="2">
                            Rencana Target <br>
                            Kegiatan
                        </th>
                        <th colspan="2">
                            Hasil Pelaksanaan
                        </th>
                        <th rowspan="2">
                            Progres (%)
                        </th>
                        <th rowspan="2">
                            Kendala
                        </th>
                        <th rowspan="2">
                            Rencana Tindak Lanjut
                        </th>
                        <th rowspan="2">
                            Lampiran Dokumen PDF
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Perilaku
                        </th>
                        <th>
                            Phisik
                        </th>
                        <th>
                            Perilaku
                        </th>
                        <th>
                            Phisik
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            const formPrint = $('#formPrint');

            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');

            selectAspectId.change(function () {
                if (selectAspectId.val()) {
                    let newOption;

                    selectWorkGroupId.attr('disabled');

                    axios.post('{{ route('api.work-groups') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        aspect: selectAspectId.val(),
                    })
                        .then(function (response) {
                            selectWorkGroupId.empty();

                            let workGroupIdVal = Number("{{ old('work_group_id', request()->get('work_group_id')) }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkGroupId.append(newOption);
                            });

                            selectWorkGroupId.removeAttr('disabled');

                            if (workGroupIdVal) {
                                selectWorkGroupId.val(('{{ old('work_group_id', request()->get('work_group_id')) }}')).trigger('change');
                            }
                        })
                }
            });

            selectAspectId.val(('{{ old('aspect_id', request()->get('aspect_id')) }}')).trigger('change');

            $('#btnView').click(function () {
                formPrint.attr('action', '{{ route('school.evaluations.index', $school_slug) }}');
                formPrint.attr('target', '');
                formPrint.submit();
            });

            $('#btnPrint').click(function () {
                formPrint.attr('action', '{{ route('school.evaluations.print', $school_slug) }}');
                formPrint.attr('target', '_blank');
                formPrint.submit();
            })

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let dtOverrideGlobals = {
                dom: "<'row'<'col-sm-12 mb-sm-3'B>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: dtButtons,
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }],
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: {
                    url: "{{ route('school.evaluations.index', ['school_slug' => $school_slug]) }}",
                    data: {
                        year: "{{ request()->get('year', date('Y')) }}",
                        aspect_id: "{{ request()->get('aspect_id') ?? '' }}",
                        work_group_id: "{{ request()->get('work_group_id') ?? '' }}",
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                    {data: 'work_program_name', name: 'work_program.name'},
                    {data: 'work_program_study_behavioral', name: 'work_program.study.behavioral'},
                    {data: 'work_program_study_physical', name: 'work_program.study.physical'},
                    {data: 'behavioral', name: 'behavioral'},
                    {data: 'physical', name: 'physical'},
                    {data: 'percentage', name: 'percentage'},
                    {data: 'problem', name: 'problem'},
                    {data: 'plan', name: 'plan'},
                    {data: 'document', name: 'document', sortable: false, searchable: false},
                ],
                order: [[0, 'asc']],
                pageLength: 10,
            };
            $('.datatable-Activity').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
    </script>
@endsection
