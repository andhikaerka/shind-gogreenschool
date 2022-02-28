@extends('layouts.admin')

@section('title', 'Dashboard')
@section('content-header', 'Dashboard')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="d-flex justify-content-center">
                                <form action="" method="get" class="mb-3 form-inline" id="yearForm">
                                    <label class="input-group-text bg-transparent border-0" for="year">
                                        Grafik Kondisi Sekolah
                                    </label>
                                    <input style="width: 60px !important;"
                                           class="form-control year rounded-left {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                           type="text" name="year" autocomplete="off"
                                           id="year" value="{{ request()->get('year', date('Y')) }}"
                                           minlength="4" maxlength="4" data-toggle="datetimepicker"
                                           data-target="#year" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                </form>
                            </div>

                            {{--<!-- PIE CHART -->--}}
                            <div class="mb-3">
                                <canvas id="pieChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <div>
                                <h6>Keterangan:</h6>
                                <span>{{ $activeSchoolCount }} Sekolah Aktif | {{ $passiveSchoolCount }} Pasif | {{ $inactiveSchoolCount }} Tdk Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Capaian Kondisi Sekolah</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Predikat</th>
                                    <th>Nilai Awal</th>
                                    <th>Go Greenschool</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Calon Adiwiyata</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Kab/Kota</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Provinsi</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Nasional</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Mandiri</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Asean Eco School</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Go Green School</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
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
            $('input#year').on("change.datetimepicker", function () {
                $('form#yearForm').submit();
            })

            new Chart($('#pieChart').get(0).getContext('2d'), {
                type: 'pie',
                data: {
                    labels: [
                        'Aktif',
                        'Tdk Aktif',
                        'Pasif',
                    ],
                    datasets: [
                        {
                            data: [Number('{{ $activeSchoolCount }}'), Number('{{ $inactiveSchoolCount }}'), Number('{{ $passiveSchoolCount }}')],
                            backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                }
            });
        })
    </script>
@endsection
