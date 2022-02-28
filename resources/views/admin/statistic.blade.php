@extends('layouts.admin')

@section('title', 'Statistik')
@section('content-header', 'Statistik')

@section('content-subheader', 'Grafik progres keaktifan sekolah dalam kegiatan lingkungan hidup')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h5>Statistik Kegiatan Sekolah</h5>
                        <h6>Berdasarkan Aktivitas Lingkungan Hidup di Sekolah</h6>

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

                        <div class="mb-3">
                            <canvas id="lineChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <h5>Aktivitas Bulan / Tahun</h5>
                        <ol type="1">
                            <li>Sekolah aktif adalah sekolah yang selalu mengikuti dan melakukan kegiatan dalam 12 bulan</li>
                            <li>Sekolah pasif adalah sekolah yang kurang dari 8 bulan berkegiatan dalam mengelola lingkungan hidup sekolah</li>
                            <li>Sekolah tidak aktif adalah sekolah yang kurang dari 4 bulan melakukan kegiatan lingkungan hidup dalam setahun</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    {{--<!-- ChartJS -->--}}
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
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

            new Chart($('#lineChart').get(0).getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    datasets: [{
                        label: 'Sekolah Aktif',
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        data: {!! json_encode($activeSchoolCounts) !!},
                        fill: false,
                    }, {
                        label: 'Sekolah Tidak Aktif',
                        fill: false,
                        backgroundColor: '#dc3545',
                        borderColor: '#dc3545',
                        data: {!! json_encode($inactiveSchoolCounts) !!},
                    }, {
                        label: 'Sekolah Pasif',
                        fill: false,
                        backgroundColor: '#ffc107',
                        borderColor: '#ffc107',
                        data: {!! json_encode($passiveSchoolCounts) !!},
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        position: 'bottom'
                    },
                }
            });
        })
    </script>
@endsection
