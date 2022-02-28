@extends('layouts.school')

@section('title', trans('global.dashboard').' - '.trans('panel.site_title'))
@section('content-header', trans('global.dashboard'))

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="text-center">
                                    <!-- PIE CHART -->
                                    <canvas id="pieChart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <strong>Keterangan:</strong>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Komponen</th>
                                            <th>Target</th>
                                            <th>Hasil</th>
                                            <th>Progres %</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Kader Siswa</td>
                                            <td>10%</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>RPP Lingkungan Hidup</td>
                                            <td>15%</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Sarana Prasarana LH</td>
                                            <td>20%</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Dok. Perencanaan</td>
                                            <td>25%</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Realisasi Pelaksanaan Aksi LH</td>
                                            <td>30%</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2">Kondisi Saat Ini</td>
                                            <td>100%</td>
                                            <td>.......%</td>
                                            <td>.......%</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">
                                <div class="circle bg-danger rounded-circle p-4 mb-3 d-flex">
                                    <span class="align-middle m-auto">{{ $schoolProfile->studies_percentage < 100 ? $schoolProfile->studies_percentage : 100 }}%</span>
                                </div>
                                <p class="lead text-uppercase">Kajian Lingkungan</p>
                            </div>
                            <div class="col text-center">
                                <div class="circle bg-warning rounded-circle p-4 mb-3 d-flex">
                                    <span class="align-middle m-auto">
                                        @if($schoolProfile->workProgramsScore['total'] < 40)
                                            {{ round($schoolProfile->workProgramsScore['total'] / 40 * 100) }}%
                                        @else
                                            100%
                                        @endif
                                    </span>
                                </div>
                                <p class="lead text-uppercase">Rencana Aksi Sekolah</p>
                            </div>
                            <div class="col text-center">
                                <div class="circle bg-success rounded-circle p-4 mb-3 d-flex">
                                    <span class="align-middle m-auto">
                                        @if($schoolProfile->total_students > 1 && !(($schoolProfile->cadres_count / $schoolProfile->total_students * 100) % 1 == 0))
                                            {{ round($schoolProfile->cadres_count / $schoolProfile->total_students * 100 ) }}%
                                        @elseif($schoolProfile->total_students > 1)
                                            {{ round($schoolProfile->cadres_count / $schoolProfile->total_students * 100 ) }}%
                                        @else
                                            100%
                                        @endif
                                    </span>
                                </div>
                                <p class="lead text-uppercase">Jumlah Kader LH</p>
                            </div>
                            <div class="col text-center">
                                <div class="circle bg-primary rounded-circle p-4 mb-3 d-flex">
                                    <span
                                        class="align-middle m-auto">{{ count($schoolProfile->schoolProfilelessonPlans ?? []) }}</span>
                                </div>
                                <p class="lead text-uppercase">Jumlah RPP</p>
                            </div>
                            <div class="col text-center">
                                <div class="circle bg-info rounded-circle p-4 mb-3 d-flex">
                                    <span
                                        class="align-middle m-auto">{{ count($schoolProfile->schoolProfilePartners ?? []) }}</span>
                                </div>
                                <p class="lead text-uppercase">Jumlah Mitra</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row" id="schools">
                            <div class="col-12">
                                <div class="text-center">
                                    <h1 class="text-uppercase">Capaian Nilai</h1>
                                </div>

                                <div class="float-sm-left">
                                    <form class="form-inline mb-3">
                                        <label class="my-1 mr-2" for="year">Tahun</label>
                                        <input
                                            class="form-control year rounded-left my-1 mr-sm-5 {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                            type="text" name="year" autocomplete="off"
                                            id="year" value="{{ request()->get('year', date('Y')) }}"
                                            minlength="4" maxlength="4" data-toggle="datetimepicker" data-target="#year"
                                            required>
                                    </form>
                                </div>
                                <div class="float-sm-right">
                                    <form class="form-inline mb-3">
                                        <label class="my-1 mr-2">Total Skor: </label>
                                        <span
                                            class="form-control form-control-plaintext font-weight-bold my-1 mr-sm-5">{{ $schoolProfile->score }}</span>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Komponen</th>
                                            <th scope="col">Skor</th>
                                            <th scope="col">Link</th>
                                            <th scope="col">&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                Rencana Aksi & Kegiatan pengelolaan lingkungan hidup di sekolah sesuai
                                                dengan EDS dan
                                                Kajian Lingkungan Sekolah
                                            </td>
                                            <td>2</td>
                                            <td>Klik</td>
                                            <td rowspan="5">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>
                                                Penyusunan Aksi dan Kegiatan Pengelolaan lingungan hidup di sekolah
                                                melibatkan berbagai
                                                pihak sekolah.
                                            </td>
                                            <td>2</td>
                                            <td>Klik</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>
                                                Rencana Aksi dan Kegiatan Lingkungan sekolah sesuai dalam dokumen
                                                kebijakan sekolah
                                            </td>
                                            <td>2</td>
                                            <td>Klik</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>
                                                Gerakan kegiatan pengelolaan lingkungan sekolah terintegrasi dalam
                                                proses belajar sesuai
                                                aspek penerapan bidang LH di Sekolah
                                            </td>
                                            <td>2</td>
                                            <td>Klik</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>
                                                Prosentasi RPP yang mengintegrasikan aspek penerapan PRLH
                                            </td>
                                            <td>2</td>
                                            <td>Klik</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <i class="float-right">
                                    Catatan: Sumber berdasarkan capaian indikator dan komponen dalam Permen LH 52 dan 53
                                </i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <h1 class="text-uppercase">
                                        Inovasi & Unggulan Program LH Sekolah
                                    </h1>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Inovasi</th>
                                            <th scope="col">Manfaat - Fungsi LH</th>
                                            <th scope="col">Foto</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($mergedInnovationsAndFeaturedWorkPrograms as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->name ?? '' }}</td>
                                                <td>{{ $item->advantage ?? '' }}</td>
                                                <td>
                                                    @if($item->photo)
                                                        <a href="{{ $item->photo->getUrl() }}" target="_blank">
                                                            {{ trans('global.view_file') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .select2.select2-container.select2-container--bootstrap4 {
            width: auto !important;
        }

        div.circle {
            width: 10em;
            height: 10em;
            margin: auto;
        }

        div.circle span {
            font-size: 2.5em;
        }
    </style>
@endsection

@section('scripts')
    @parent
    {{--<!-- ChartJS -->--}}
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function () {
            new Chart($('#pieChart').get(0).getContext('2d'), {
                type: 'pie',
                data: {
                    labels: [
                        'Perencanaan 20% (max skor 45)',
                        'Pelaksanaan 60% (max skor 13)',
                        'Monev 20% (max skor 12)',
                    ],
                    datasets: [
                        {
                            data: [{!! $planning !!}, {!! $implementation !!}, {!! $monev !!}],
                            backgroundColor: ['#17a2b8', '#dc3545', '#007bff'],
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
