@extends('layouts.school')

@section('title', 'Statistik - '.trans('panel.site_title'))
@section('content-header', 'Statistik')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <center>
                                <h2>GRAFIK STATISTIK</h2>
                                <h2>JUMLAH KEGIATAN SEKOLAH</h2>
                            </center>
                            <canvas id="lineChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        <small>**Dihitung berdasarkan input / keaktifan kegiatan sekolah.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    @parent
    {{--<!-- ChartJS -->--}}
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [{
                    label: 'Progres Aktifitas',
                    data: {!! json_encode($activities) !!},
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
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
    </script>
@endsection
