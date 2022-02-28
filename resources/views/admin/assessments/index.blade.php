@extends('layouts.admin')

@section('title', 'Verifikasi Penilaian Sekolah')

@section('content-header', 'Verifikasi Penilaian Sekolah')

@section('content')
    <div class="card">
        <div class="card-header border-bottom-0">
            Penilaian
        </div>

        <div class="card-body border-top-0">
            <form action="" method="get" class="form-inline my-3">
                <div class="form-group">
                    <label for="year" class="my-1 mr-2">Tahun</label>
                    <input
                        class="form-control year rounded-left my-1 mr-sm-2 {{ $errors->has('year') ? 'is-invalid' : '' }}"
                        type="text" name="year" autocomplete="off"
                        id="year" value="{{ request()->get('year', date('Y')) }}"
                        minlength="4" maxlength="4" data-toggle="datetimepicker"
                        data-target="#year" {{ app()->environment() == 'production' ? 'required' : '' }}>
                </div>
                <div class="form-group">
                    <label for="province" class="my-1 mr-2">{{ trans('crud.city.fields.province') }}</label>
                    <select class="form-control select2 my-1 mr-sm-2 {{ $errors->has('province') ? 'is-invalid' : '' }}"
                            name="province" id="province">
                        <option value {{ old('province', null) == null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        @foreach($provinces as $code => $province)
                            <option value="{{ $code }}" {{ $code == request()->get('province') ? 'selected' : '' }}>
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="city" class="my-1 mx-2">{{ trans('crud.school.fields.city') }}</label>
                    <select class="form-control select2 my-1 mr-sm-2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city"
                            id="city" disabled>
                        <option value {{ old('city', null) == null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-info my-1 ml-2">Lihat</button>
            </form>

            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Assessment">
                <thead>
                <tr>
                    <th>
                        No
                    </th>
                    <th>
                        Nama Sekolah
                    </th>
                    <th>
                        Tingkatan Sekolah/Sederajat
                    </th>
                    <th>
                        Alamat Lengkap
                    </th>
                    <th>
                        Status LH
                    </th>
                    <th>
                        Penilaian
                    </th>
                    <th>
                        Aksi (Edit - Hapus)
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
            const selectProvince = $('select#province');
            const selectCity = $('select#city');

            let newOption;

            selectProvince.change(function () {
                selectCity.attr('disabled');

                axios.post('{{ route('api.cities') }}', {
                    province: selectProvince.val(),
                })
                    .then(function (response) {
                        selectCity.empty();

                        let cityVal = "{{ request()->get('city') }}";

                        response.data.forEach(function (data) {
                            let selected = Number(data.id) === Number(cityVal);
                            newOption = new Option(data.text, data.id, selected, selected);
                            selectCity.append(newOption);
                        });

                        selectCity.removeAttr('disabled');
                    })
            });

            selectProvince.val("{{ request()->get('province') }}").trigger('change');

            let dtOverrideGlobals = {
                columnDefs: [],
                dom: "<'row'<'col-sm-12 mb-sm-3'B>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn-default',
                        text: '{{ trans('global.datatables.copy') }}',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-default',
                        text: '{{ trans('global.datatables.csv') }}',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-default',
                        text: '{{ trans('global.datatables.excel') }}',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        text: '{{ trans('global.datatables.pdf') }}',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        text: '{{ trans('global.datatables.print') }}',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn-default',
                        text: '{{ trans('global.datatables.colvis') }}',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                processing: true,
                serverSide: true,
                retrieve: true,
                ajax: {
                    url: "{{ route('admin.assessments.index') }}",
                    data: {
                        year: "{{ request()->get('year', date('Y')) }}",
                        province: "{{ request()->get('province') }}",
                        city: "{{ request()->get('city') }}",
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'level', name: 'level'},
                    {data: 'address', name: 'address'},
                    {data: 'environmental_status_name', name: 'schoolSchoolProfiles.environmental_status.name'},
                    {data: 'assessment', name: 'assessment', sortable: false, searchable: false},
                    {data: 'actions', name: '{{ trans('global.actions') }}', sortable: false, searchable: false}
                ],
                order: [[1, 'desc']],
                pageLength: 10,
            };
            $('.datatable-Assessment').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });

    </script>
@endsection
