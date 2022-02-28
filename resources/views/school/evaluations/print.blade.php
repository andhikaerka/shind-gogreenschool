<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Evaluasi</title>
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
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td colspan="6" class="font-weight-bold">
                                RENCANA AKSI LINGKUNGAN JANGKA MENENGAH (4 TH)
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 107px;">Nama Sekolah</td>
                            <td style="width: 14px;">:</td>
                            <td style="width: 428px;">{{ $school->name }}</td>
                            <td style="width: 107px;">Periode / TH</td>
                            <td style="width: 14px;">:</td>
                            <td>{{ request()->get('year', date('Y')) }}</td>
                        </tr>
                        <tr>
                            <td style="width: 107px;">Alamat</td>
                            <td style="width: 14px;">:</td>
                            <td colspan="4">
                                <span>{{ $school->address }}, {{ $school->city->name }}, {{ $school->city->province->name }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            {{--<!-- /.col -->--}}
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                    <tr>
                        <th rowspan="3" class="align-middle font-weight-normal">
                            NO
                        </th>
                        <th colspan="2" rowspan="2" class="small font-weight-bold">
                            KAJIAN LINGKUNGAN PEMETAAN LH
                        </th>
                        <th colspan="12" class="text-center text-nowrap small font-weight-bold">
                            RENCANA AKSI KEGIATAN PENGELOLAAN DAN PERLINDUNGAN LH DI SEKOLAH 4 TH
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="text-center align-middle text-nowrap">JENIS KEGIATAN</th>
                        <th colspan="4" class="text-center text-nowrap small font-weight-bold">
                            TAHUN
                        </th>
                        <th colspan="2" class="text-center text-nowrap small font-weight-bold">
                            PERUBAHAN
                        </th>
                        <th rowspan="2" class="text-center align-middle small font-weight-bold">
                            SUMBER BIAYA
                        </th>
                        <th rowspan="2" class="text-center align-middle small font-weight-bold">
                            PENJAB
                        </th>
                        <th rowspan="2" class="text-center align-middle small font-weight-bold">
                            PIHAK TERKAIT
                        </th>
                    </tr>
                    <tr>
                        <th class="align-top text-nowrap font-weight-normal">MASALAH</th>
                        <th class="align-top text-nowrap font-weight-normal">POTENSI</th>
                        <th class="align-top text-nowrap font-weight-normal">1</th>
                        <th class="align-top text-nowrap font-weight-normal">2</th>
                        <th class="align-top text-nowrap font-weight-normal">3</th>
                        <th class="align-top text-nowrap font-weight-normal">4</th>
                        <th class="font-weight-normal">PERILAKU</th>
                        <th class="font-weight-normal">PHISIK</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($studies as $key => $study)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $study->problem ?? '' }}</td>
                            <td>{{ $study->potential ?? '' }}</td>
                            <td>{{ $study->activity ?? '' }}</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>{{ $study->behavioral ?? '' }}</td>
                            <td>{{ $study->physical ?? '' }}</td>
                            <td>&nbsp;</td>
                            <td>
                                {{ join(',', $study->teams()->pluck('name')->toArray()) }}
                            </td>
                            <td>{{ $study->partner->name ?? '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th colspan="5">Di sahkan , {{ $school->city->name ?? '' }}</th>
                        </tr>
                        <tr>
                            <th colspan="5">Tanggal , {{ strftime('%e %B %Y', strtotime('now')) }}</th>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5">Mengetahui,</th>
                        </tr>
                        <tr class="text-center">
                            <td>Kepala Sekolah</td>
                            <td>Komite</td>
                            <td>Dewan Pendidikan</td>
                            <td>Tokoh Masyarakat</td>
                            <td>Kader Siswa</td>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr class="text-center">
                            <td>....................................</td>
                            <td>....................................</td>
                            <td>....................................</td>
                            <td>....................................</td>
                            <td>....................................</td>
                        </tr>
                    </table>
                </div>
            </div>
            {{--<!-- /.col -->--}}
        </div>
        {{--<!-- /.row -->--}}
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
