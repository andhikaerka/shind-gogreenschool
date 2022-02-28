<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PROFIL SEKOLAH</title>
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

            @page {
                size: 21cm 29.7cm;
            }

            .invoice.p-2 {
                padding: unset !important;
            }

        }
        body {
            padding: 2cm;
            height:297mm;
            width:210mm;
            margin-left:auto;
            margin-right:auto;
            font-size: 13px;
        }
    </style>
</head>
<body class="m-2 p-m-0">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice p-2">
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.name') }}
                        </th>
                        <td>
                            {{ $school->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.level') }}
                        </th>
                        <td>
                            {{ App\School::LEVEL_SELECT[$school->level] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.vision') }}
                        </th>
                        <td>
                            {{ $schoolProfile->vision ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.status') }}
                        </th>
                        <td>
                            {{ App\School::STATUS_SELECT[$school->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.address') }}
                        </th>
                        <td>
                            {{ $school->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.city') }}
                        </th>
                        <td>
                            {{ $school->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.city.fields.province') }}
                        </th>
                        <td>
                            {{ $school->city->province->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.phone') }}
                        </th>
                        <td>
                            {{ $school->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.email') }}
                        </th>
                        <td>
                            {{ $school->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.website') }}
                        </th>
                        <td>
                            {{ $school->website }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_students') }}
                        </th>
                        <td>
                            {{ $schoolProfile->total_students ? number_format($schoolProfile->total_students, 0, ',', '.') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_teachers') }}
                        </th>
                        <td>
                            {{ $schoolProfile->total_teachers ? number_format($schoolProfile->total_teachers, 0, ',', '.') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_land_area') }}
                        </th>
                        <td>
                            {!! $schoolProfile->total_land_area ? number_format($schoolProfile->total_land_area, 0, ',', '.').' &#13217;' : '' !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.total_building_area') }}
                        </th>
                        <td>
                            {!! $schoolProfile->total_building_area ? number_format($schoolProfile->total_building_area, 0, ',', '.').' &#13217;' : '' !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.logo') }}
                        </th>
                        <td>
                            @if($school->logo)
                                <a href="{{ $school->logo->getUrl() }}" target="_blank">
                                    <img src="{{ $school->logo->getUrl() }}" width="50px" height="50px" alt="">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.school.fields.photo') }}
                        </th>
                        <td>
                            @if($schoolProfile->photo)
                                <a href="{{ $schoolProfile->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        {{--<!-- /.row -->--}}
    </section>
    {{--<!-- /.content -->--}}
</div>
{{--<!-- ./wrapper -->--}}

    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>
</html>
