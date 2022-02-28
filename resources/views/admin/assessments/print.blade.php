<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Penilaian</title>
    {{--<!-- Tell the browser to be responsive to screen width -->--}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<!-- Bootstrap 4 -->--}}
    {{--<!-- Font Awesome -->--}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    {{--<!-- Theme style -->--}}
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    {{--<!-- Google Font: Source Sans Pro -->--}}
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        @media print {
            .p-m-0 {
                margin: unset !important;
            }

            .invoice.p-2 {
                padding: unset !important;
            }
        }
    </style>
</head>
<body class="m-2 p-m-0">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice p-2">

        <div class="row invoice-info">
            <div class="col-12 invoice-col">
                <div class="card">
                    <div class="card-header border-bottom-0">
                        Penilaian
                    </div>

                    <div class="card-body border-top-0">
                        <p class="card-text">
                            Merupakan kegiatan sekolah yang mengacu terhadap peningkatan fungsi lingkungan hidup secara
                            detail dari
                            komponen dan indikator yang sesuai dengan ketentuan resmi Pemerintah dalam program sekolah
                            Adiwiyata
                        </p>

                        <div class="row form-row d-flex justify-content-between mb-3">
                            <div class="col mr-sm-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label
                                            class="{{ app()->environment() == 'production' ? 'required' : '' }} input-group-text bg-transparent border-0"
                                            for="year">{{ trans('crud.schoolProfile.fields.year') }}&nbsp;:</label>
                                    </div>
                                    <div class="form-control form-control-plaintext">{{ request()->get('year', date('Y')) }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text bg-transparent border-0">Total
                                            Skor&nbsp;:</label>
                                    </div>
                                    <div class="input-group-append">
                                        <div class="input-group-text bg-transparent border-0" id="recordsScore">
                                            {{ $assessment->score ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Komponen
                                    </th>
                                    <th>
                                        Indikator
                                    </th>
                                    <th>
                                        Skor
                                    </th>
                                    <th>
                                        Link
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        Rencana Aksi & Kegiatan pengelolaan lingkungan hidup di sekolah sesuai dengan
                                        EDS dan
                                        Kajian
                                        Lingkungan Sekolah
                                    </td>
                                    <td>{{ ($assessment->component_1 ?? false) && isset(\App\Assessment::COMPONENT_1_SELECT[$assessment->component_1]) ? \App\Assessment::COMPONENT_1_SELECT[$assessment->component_1] : '' }}</td>
                                    <td>{{ $assessment->component_1 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.quality-reports.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">EDS - Raport Mutu</a> <br>
                                        <a href="{{ route('school.studies.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">IPMLH Sekolah</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        Penyusunan Aksi dan Kegiatan Pengelolaan lingkungan hidup di sekolah melibatkan
                                        berbagai
                                        pihak sekolah
                                    </td>
                                    <td>{{ ($assessment->component_2 ?? false) && isset(\App\Assessment::COMPONENT_2_SELECT[$assessment->component_2]) ? \App\Assessment::COMPONENT_2_SELECT[$assessment->component_2] : '' }}</td>
                                    <td>{{ $assessment->component_2 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.teams.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Tim LH
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>
                                        Rencana Aksi dan Kegiatan Lingkungan sekolah sesuai dalam dokumen
                                        kebijakan sekolah
                                    </td>
                                    <td>{{ ($assessment->component_3 ?? false) && isset(\App\Assessment::COMPONENT_3_SELECT[$assessment->component_3]) ? \App\Assessment::COMPONENT_3_SELECT[$assessment->component_3] : '' }}</td>
                                    <td>{{ $assessment->component_3 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.curricula.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            KTSP
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>
                                        Gerakan kegiatan pengelolaan lingkungan sekolah terintegrasi datam proses
                                        betajar sesuai
                                        aspek penerapan bidang LH di Sekolah
                                    </td>
                                    <td>{{ ($assessment->component_4 ?? false) && isset(\App\Assessment::COMPONENT_4_SELECT[$assessment->component_4]) ? \App\Assessment::COMPONENT_4_SELECT[$assessment->component_4] : '' }}</td>
                                    <td>{{ $assessment->component_4 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.work-groups.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Nama Pokja
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>Prosentasi RPP yang mengintegrasikan aspek penerapan PRLH</td>
                                    <td>{{ ($assessment->component_5 ?? false) && isset(\App\Assessment::COMPONENT_5_SELECT[$assessment->component_5]) ? \App\Assessment::COMPONENT_5_SELECT[$assessment->component_5] : '' }}</td>
                                    <td>{{ $assessment->component_5 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.lesson-plans.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Silabus - RPP
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td>
                                        Unsur warga sekolah yang terlibat dalam pelaksanaan kegiatan Lingkungan Hidup.
                                    </td>
                                    <td>{{ ($assessment->component_6 ?? false) && isset(\App\Assessment::COMPONENT_6_SELECT[$assessment->component_6]) ? \App\Assessment::COMPONENT_6_SELECT[$assessment->component_6] : '' }}</td>
                                    <td>{{ $assessment->component_6 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.teams.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Tim LH
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>7</td>
                                    <td>
                                        Upaya dalam kebersihan dan fungsi drainase di sekolah
                                    </td>
                                    <td>{{ ($assessment->component_7 ?? false) && isset(\App\Assessment::COMPONENT_7_SELECT[$assessment->component_7]) ? \App\Assessment::COMPONENT_7_SELECT[$assessment->component_7] : '' }}</td>
                                    <td>{{ $assessment->component_7 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>8</td>
                                    <td>
                                        Upaya dalam pengurangan sampah (Reduce & Reuse)
                                    </td>
                                    <td>{{ ($assessment->component_8 ?? false) && isset(\App\Assessment::COMPONENT_8_SELECT[$assessment->component_8]) ? \App\Assessment::COMPONENT_8_SELECT[$assessment->component_8] : '' }}</td>
                                    <td>{{ $assessment->component_8 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>9</td>
                                    <td>
                                        Upaya dalam pengolahan daur ulang sampah
                                    </td>
                                    <td>{{ ($assessment->component_9 ?? false) && isset(\App\Assessment::COMPONENT_9_SELECT[$assessment->component_9]) ? \App\Assessment::COMPONENT_9_SELECT[$assessment->component_9] : '' }}</td>
                                    <td>{{ $assessment->component_9 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>9</td>
                                    <td>
                                        Peran aktif warga sekolah dalam mengelola bank sampah dan komposting
                                    </td>
                                    <td>{{ ($assessment->component_10 ?? false) && isset(\App\Assessment::COMPONENT_10_SELECT[$assessment->component_10]) ? \App\Assessment::COMPONENT_10_SELECT[$assessment->component_10] : '' }}</td>
                                    <td>{{ $assessment->component_10 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadres.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Kader Siswa
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>10</td>
                                    <td>1
                                        Pengurangan timbunan sampah dengan gerakan 3 R
                                    </td>
                                    <td>{{ ($assessment->component_11 ?? false) && isset(\App\Assessment::COMPONENT_11_SELECT[$assessment->component_11]) ? \App\Assessment::COMPONENT_11_SELECT[$assessment->component_11] : '' }}</td>
                                    <td>{{ $assessment->component_11 ?? '' }}</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>11</td>
                                    <td>
                                        Upaya menghijaukan sekolah (Pembibitan-penanaman dan pemeliharaan /panen)
                                    </td>
                                    <td>{{ ($assessment->component_12 ?? false) && isset(\App\Assessment::COMPONENT_12_SELECT[$assessment->component_12]) ? \App\Assessment::COMPONENT_12_SELECT[$assessment->component_12] : '' }}</td>
                                    <td>{{ $assessment->component_12 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>12</td>
                                    <td>
                                        Unsur warga sekolah yang terlibat dalam program penghijauan sekolah
                                    </td>
                                    <td>{{ ($assessment->component_13 ?? false) && isset(\App\Assessment::COMPONENT_13_SELECT[$assessment->component_13]) ? \App\Assessment::COMPONENT_13_SELECT[$assessment->component_13] : '' }}</td>
                                    <td>{{ $assessment->component_13 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.teams.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">Tim LH</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>13</td>
                                    <td>
                                        Jumlah tanaman yang di ada dan perawatan intensif
                                    </td>
                                    <td>{{ ($assessment->component_14 ?? false) && isset(\App\Assessment::COMPONENT_14_SELECT[$assessment->component_14]) ? \App\Assessment::COMPONENT_14_SELECT[$assessment->component_14] : '' }}</td>
                                    <td>{{ $assessment->component_14 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>14</td>
                                    <td>
                                        Upaya dan konservasi air di sekolah
                                    </td>
                                    <td>{{ ($assessment->component_15 ?? false) && isset(\App\Assessment::COMPONENT_15_SELECT[$assessment->component_15]) ? \App\Assessment::COMPONENT_15_SELECT[$assessment->component_15] : '' }}</td>
                                    <td>{{ $assessment->component_15 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>15</td>
                                    <td>
                                        Inovasi dan program unggulan lingkungan hidup di sekolah
                                    </td>
                                    <td>{{ ($assessment->component_16 ?? false) && isset(\App\Assessment::COMPONENT_16_SELECT[$assessment->component_16]) ? \App\Assessment::COMPONENT_16_SELECT[$assessment->component_16] : '' }}</td>
                                    <td>{{ $assessment->component_16 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.innovations.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Inovasi LH
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>16</td>
                                    <td>
                                        Penerapan Perilaku Ramah Lingkungan Hidup di sekitar sekolah
                                    </td>
                                    <td>{{ ($assessment->component_17 ?? false) && isset(\App\Assessment::COMPONENT_17_SELECT[$assessment->component_17]) ? \App\Assessment::COMPONENT_17_SELECT[$assessment->component_17] : '' }}</td>
                                    <td>{{ $assessment->component_17 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">Kemitraan</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>17</td>
                                    <td>
                                        Kebersiahan dan fungsi drainase di sekitar sekolah
                                    </td>
                                    <td>{{ ($assessment->component_18 ?? false) && isset(\App\Assessment::COMPONENT_18_SELECT[$assessment->component_18]) ? \App\Assessment::COMPONENT_18_SELECT[$assessment->component_18] : '' }}</td>
                                    <td>{{ $assessment->component_18 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">Kemitraan</a>
                                        dan
                                        <a href="{{ route('school.activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>18</td>
                                    <td>
                                        Pengelolaan sampah di sekitar sekolah
                                    </td>
                                    <td>{{ ($assessment->component_19 ?? false) && isset(\App\Assessment::COMPONENT_19_SELECT[$assessment->component_19]) ? \App\Assessment::COMPONENT_19_SELECT[$assessment->component_19] : '' }}</td>
                                    <td>{{ $assessment->component_19 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">Kemitraan</a>
                                        dan
                                        <a href="{{ route('school.activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>19</td>
                                    <td>
                                        Jejaring kerja sekolah dengan berbagai pihak terkait LH (dinas dll)
                                    </td>
                                    <td>{{ ($assessment->component_20 ?? false) && isset(\App\Assessment::COMPONENT_20_SELECT[$assessment->component_20]) ? \App\Assessment::COMPONENT_20_SELECT[$assessment->component_20] : '' }}</td>
                                    <td>{{ $assessment->component_20 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">Kemitraan</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>20</td>
                                    <td>
                                        Kegiatan kampanye dan publikasi gerakan LH Sekolah
                                    </td>
                                    <td>{{ ($assessment->component_21 ?? false) && isset(\App\Assessment::COMPONENT_21_SELECT[$assessment->component_21]) ? \App\Assessment::COMPONENT_21_SELECT[$assessment->component_21] : '' }}</td>
                                    <td>{{ $assessment->component_21 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">Kemitraan</a>
                                        dan
                                        <a href="{{ route('school.activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>21</td>
                                    <td>
                                        Media Publikasi untuk gerakan LH Sekolah
                                    </td>
                                    <td>{{ ($assessment->component_22 ?? false) && isset(\App\Assessment::COMPONENT_22_SELECT[$assessment->component_22]) ? \App\Assessment::COMPONENT_22_SELECT[$assessment->component_22] : '' }}</td>
                                    <td>{{ $assessment->component_22 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">Kemitraan</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>22</td>
                                    <td>
                                        Prosentase jumlah kader LH dengan jumlah warga di sekolah
                                    </td>
                                    <td>{{ ($assessment->component_23 ?? false) && isset(\App\Assessment::COMPONENT_23_SELECT[$assessment->component_23]) ? \App\Assessment::COMPONENT_23_SELECT[$assessment->component_23] : '' }}</td>
                                    <td>{{ $assessment->component_23 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.cadres.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Jumlah Kader Pokja
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>23</td>
                                    <td>
                                        Kegiatan kader siswa
                                    </td>
                                    <td>{{ ($assessment->component_24 ?? false) && isset(\App\Assessment::COMPONENT_24_SELECT[$assessment->component_24]) ? \App\Assessment::COMPONENT_24_SELECT[$assessment->component_24] : '' }}</td>
                                    <td>{{ $assessment->component_24 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.work-programs.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Program Kerja Kader
                                        </a>
                                        dan
                                        <a href="{{ route('school.cadre-activities.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Pelaksanaan Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>24</td>
                                    <td>
                                        Frekwensi pemantauan dan evaluasi pelaksanaan kegiatan LH sekolah
                                    </td>
                                    <td>{{ ($assessment->component_25 ?? false) && isset(\App\Assessment::COMPONENT_25_SELECT[$assessment->component_25]) ? \App\Assessment::COMPONENT_25_SELECT[$assessment->component_25] : '' }}</td>
                                    <td>{{ $assessment->component_25 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.monitors.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Laporan Monitoring
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>25</td>
                                    <td>
                                        Prosentase tercapaian rencana kegiatan dalam pelaksanaan di sekolah
                                    </td>
                                    <td>{{ ($assessment->component_26 ?? false) && isset(\App\Assessment::COMPONENT_26_SELECT[$assessment->component_26]) ? \App\Assessment::COMPONENT_26_SELECT[$assessment->component_26] : '' }}</td>
                                    <td>{{ $assessment->component_26 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.evaluations.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Evaluasi Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>26</td>
                                    <td>
                                        Pelaksana kegiatan pemantauan dan evaluasi LH di sekolah
                                    </td>
                                    <td>{{ ($assessment->component_27 ?? false) && isset(\App\Assessment::COMPONENT_27_SELECT[$assessment->component_27]) ? \App\Assessment::COMPONENT_27_SELECT[$assessment->component_27] : '' }}</td>
                                    <td>{{ $assessment->component_27 ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('school.evaluations.index', ['school_slug' => $school_slug]) }}"
                                           target="_blank">
                                            Evaluasi Kegiatan
                                        </a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            {{--<!-- /.col -->--}}
        </div>
        <!-- /.row -->
    </section>
    {{--<!-- /.content -->--}}
</div>
{{--<!-- ./wrapper -->--}}

@if(app()->environment() == 'production')
    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
@endif
</body>
</html>
