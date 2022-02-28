@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-12">
                <div class="card bg-transparent border-0">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <img src="{{ asset('img/logo.png') }}" alt="" class="img-fluid d-flex mx-auto mb-5"
                             style="max-width: 300px;">

                        <p id="program" class="lead text-center">
                            Adalah sistem Online untuk pencapaian indikator kegiatan pengelolaan dan perlindungan
                            Iingkungan hidup di sekolah sesuai dengan rencana kegiatan. pelaksanaan dan hasil-hasil
                            akhir dengan mekanisme monitoring serta evaluasi yang dilaksanakan berdasarkan
                            komponen yang telah ditentukan dalam meningkatkan fungsi Iingkungan hidup sebagai sekolah
                            peduli dan berbudaya Iingkungan hidup.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col text-center">
                <i class="fas fa-5x fa-check bg-danger rounded-circle p-4 mb-3"></i>
                <p class="lead text-uppercase">Praktis</p>
            </div>
            <div class="col text-center">
                <i class="fas fa-5x fa-archive bg-warning rounded-circle p-4 mb-3"></i>
                <p class="lead text-uppercase">Arsip</p>
            </div>
            <div class="col text-center">
                <i class="fas fa-5x fa-sync bg-success rounded-circle p-4 mb-3"></i>
                <p class="lead text-uppercase">Progres</p>
            </div>
            <div class="col text-center">
                <i class="fas fa-5x fa-book bg-primary rounded-circle p-4 mb-3"></i>
                <p class="lead text-uppercase">Transparan</p>
            </div>
            <div class="col text-center">
                <i class="fas fa-5x fa-search bg-info rounded-circle p-4 mb-3"></i>
                <p class="lead text-uppercase">Akurat</p>
            </div>
        </div>

        <div class="row mb-5" id="schools">
            <div class="col-12">
                <div class="text-center">
                    <h1 class="text-uppercase">Sekolah Mitra</h1>
                </div>

                <form class="form-inline justify-content-center mb-3">
                    <label class="my-1 mr-2" for="year">Tahun</label>
                    <input
                        class="form-control year rounded-left my-1 mr-sm-5 {{ $errors->has('year') ? 'is-invalid' : '' }}"
                        type="text" name="year" autocomplete="off"
                        id="year" value="{{ request()->get('year', date('Y')) }}"
                        minlength="4" maxlength="4" data-toggle="datetimepicker" data-target="#year" required>

                    <label class="my-1 mr-2" for="city">Kab/Kota</label>
                    <select class="custom-select my-1 mr-sm-5" id="city" name="city">
                        <option value="" selected>Pilih Kab/Kota</option>
                        @foreach(\App\City::all() as $city)
                            <option
                                value="{{ $city->code }}" {{ request()->get('city', '') == $city->code ? 'selected' : '' }}>
                                {{ $city->name.($city->province ? ', '.$city->province->name : '') }}
                            </option>
                        @endforeach
                    </select>

                    <label class="my-1 mr-2" for="level">Jenjang</label>
                    <select class="custom-select my-1 mr-sm-5" id="level" name="level">
                        <option value="" selected>Pilih Jenjang</option>
                        <option value="SD" {{ request()->get('level', '') == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ request()->get('level', '') == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ request()->get('level', '') == 'SMA' ? 'selected' : '' }}>SMA</option>
                    </select>

                    <button type="submit" class="btn btn-info my-1 mr-2">Lihat</button>
                </form>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table id="datatable-School" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Status</th>
                            <th scope="col">Skor</th>
                            <th scope="col">Link</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('styles')
    {{--<!-- Select2 -->--}}
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{--<!-- Tempusdominus Bootstrap 4 -->--}}
    <link rel="stylesheet"
          href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    {{--<!-- DataTables -->--}}
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .select2.select2-container.select2-container--bootstrap4 {
            width: auto !important;
        }
    </style>
@endsection

@section('scripts')
    {{--<!-- Select2 -->--}}
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/i18n/id.js') }}"></script>
    {{--<!-- moment -->--}}
    <script src="{{ asset('plugins/moment/moment-with-locales.min.js') }}"></script>
    {{--<!-- Tempusdominus Bootstrap 4 -->--}}
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    {{--<!-- DataTables -->--}}
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $ = jQuery;

        $(function () {
            $('input#year').datetimepicker({
                locale: window._lang,
                viewMode: 'years',
                format: 'YYYY',
                maxDate: '{{ date('Y') }}'
            });

            $('select#city').select2({
                theme: 'bootstrap4',
                locale: window._lang,
            });

            $('span.select2.select2-container.select2-container--bootstrap4').addClass('my-1 mr-sm-5');

            let languages = {
                'id': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json',
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };
            $('table#datatable-School').DataTable({
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('api.schools.data') }}",
                    type: "post",
                    data: {
                        year: "{{ request()->get('year', date('Y')) }}",
                        city: "{{ request()->get('city') }}",
                        level: "{{ request()->get('level') }}",
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', sortable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    {data: 'score', name: 'score'},
                    {data: 'link', name: 'link'},
                ],
                order: [[3, "desc"]]
            });
        });
    </script>
@endsection
