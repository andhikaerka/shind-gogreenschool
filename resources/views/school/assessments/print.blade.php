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
                                    <div
                                        class="form-control form-control-plaintext">{{ request()->get('year', date('Y')) }}</div>
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
                                        {{ trans('crud.assessment.fields.component_1') }}
                                    </td>
                                    <td>
                                        {{ trans('crud.assessment.fields.component_1_helper') }}
                                    </td>
                                    <td>{{ ($assessment->component_1 ?? false) && isset(\App\Assessment::COMPONENT_1_SELECT[$assessment->component_1]) ? \App\Assessment::COMPONENT_1_SELECT[$assessment->component_1] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_1_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        2
                                    </td>
                                    <td>{{ trans('crud.assessment.fields.component_2') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_2_helper') }}</td>
                                    <td>{{ ($assessment->component_2 ?? false) && isset(\App\Assessment::COMPONENT_2_SELECT[$assessment->component_2]) ? \App\Assessment::COMPONENT_2_SELECT[$assessment->component_2] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_2_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>{{ trans('crud.assessment.fields.component_3') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_3_helper') }}</td>
                                    <td>{{ ($assessment->component_3 ?? false) && isset(\App\Assessment::COMPONENT_3_SELECT[$assessment->component_3]) ? \App\Assessment::COMPONENT_3_SELECT[$assessment->component_3] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_3_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>{{ trans('crud.assessment.fields.component_4') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_4_helper') }}</td>
                                    <td>{{ ($assessment->component_4 ?? false) && isset(\App\Assessment::COMPONENT_4_SELECT[$assessment->component_4]) ? \App\Assessment::COMPONENT_4_SELECT[$assessment->component_4] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_4_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>{{ trans('crud.assessment.fields.component_5') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_5_helper') }}</td>
                                    <td>{{ ($assessment->component_5 ?? false) && isset(\App\Assessment::COMPONENT_5_SELECT[$assessment->component_5]) ? \App\Assessment::COMPONENT_5_SELECT[$assessment->component_5] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_5_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td>{{ trans('crud.assessment.fields.component_6') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_6_helper') !!}</td>
                                    <td>{{ ($assessment->component_6 ?? false) && isset(\App\Assessment::COMPONENT_6_SELECT[$assessment->component_6]) ? \App\Assessment::COMPONENT_6_SELECT[$assessment->component_6] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_6_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>7</td>
                                    <td>{{ trans('crud.assessment.fields.component_7') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_7_helper') }}</td>
                                    <td>{{ ($assessment->component_7 ?? false) && isset(\App\Assessment::COMPONENT_7_SELECT[$assessment->component_7]) ? \App\Assessment::COMPONENT_7_SELECT[$assessment->component_7] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_7_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>8</td>
                                    <td>{{ trans('crud.assessment.fields.component_8') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_8_helper') }}</td>
                                    <td>{{ ($assessment->component_8 ?? false) && isset(\App\Assessment::COMPONENT_8_SELECT[$assessment->component_8]) ? \App\Assessment::COMPONENT_8_SELECT[$assessment->component_8] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_8_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>9</td>
                                    <td>{{ trans('crud.assessment.fields.component_9') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_9_helper') !!}</td>
                                    <td>{{ ($assessment->component_9 ?? false) && isset(\App\Assessment::COMPONENT_9_SELECT[$assessment->component_9]) ? \App\Assessment::COMPONENT_9_SELECT[$assessment->component_9] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_9_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>10</td>
                                    <td>{{ trans('crud.assessment.fields.component_10') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_10_helper') !!}</td>
                                    <td>{{ ($assessment->component_10 ?? false) && isset(\App\Assessment::COMPONENT_10_SELECT[$assessment->component_10]) ? \App\Assessment::COMPONENT_10_SELECT[$assessment->component_10] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_10_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>11</td>
                                    <td>{{ trans('crud.assessment.fields.component_11') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_11_helper') }}</td>
                                    <td>{{ ($assessment->component_11 ?? false) && isset(\App\Assessment::COMPONENT_11_SELECT[$assessment->component_11]) ? \App\Assessment::COMPONENT_11_SELECT[$assessment->component_11] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_11_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>12</td>
                                    <td>{{ trans('crud.assessment.fields.component_12') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_12_helper') }}</td>
                                    <td>{{ ($assessment->component_12 ?? false) && isset(\App\Assessment::COMPONENT_12_SELECT[$assessment->component_12]) ? \App\Assessment::COMPONENT_12_SELECT[$assessment->component_12] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_12_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>13</td>
                                    <td>{{ trans('crud.assessment.fields.component_13') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_13_helper') !!}</td>
                                    <td>{{ ($assessment->component_13 ?? false) && isset(\App\Assessment::COMPONENT_13_SELECT[$assessment->component_13]) ? \App\Assessment::COMPONENT_13_SELECT[$assessment->component_13] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_13_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>14</td>
                                    <td>{{ trans('crud.assessment.fields.component_14') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_14_helper') }}</td>
                                    <td>{{ ($assessment->component_14 ?? false) && isset(\App\Assessment::COMPONENT_14_SELECT[$assessment->component_14]) ? \App\Assessment::COMPONENT_14_SELECT[$assessment->component_14] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_14_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>15</td>
                                    <td>{{ trans('crud.assessment.fields.component_15') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_15_helper') }}</td>
                                    <td>{{ ($assessment->component_15 ?? false) && isset(\App\Assessment::COMPONENT_15_SELECT[$assessment->component_15]) ? \App\Assessment::COMPONENT_15_SELECT[$assessment->component_15] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_15_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>16</td>
                                    <td>{{ trans('crud.assessment.fields.component_16') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_16_helper') !!}</td>
                                    <td>{{ ($assessment->component_16 ?? false) && isset(\App\Assessment::COMPONENT_16_SELECT[$assessment->component_16]) ? \App\Assessment::COMPONENT_16_SELECT[$assessment->component_16] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_16_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>17</td>
                                    <td>{{ trans('crud.assessment.fields.component_17') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_17_helper') !!}</td>
                                    <td>{{ ($assessment->component_17 ?? false) && isset(\App\Assessment::COMPONENT_17_SELECT[$assessment->component_17]) ? \App\Assessment::COMPONENT_17_SELECT[$assessment->component_17] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_17_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>18</td>
                                    <td>{{ trans('crud.assessment.fields.component_18') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_18_helper') !!}</td>
                                    <td>{{ ($assessment->component_18 ?? false) && isset(\App\Assessment::COMPONENT_18_SELECT[$assessment->component_18]) ? \App\Assessment::COMPONENT_18_SELECT[$assessment->component_18] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_18_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>19</td>
                                    <td>{{ trans('crud.assessment.fields.component_19') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_19_helper') !!}</td>
                                    <td>{{ ($assessment->component_19 ?? false) && isset(\App\Assessment::COMPONENT_19_SELECT[$assessment->component_19]) ? \App\Assessment::COMPONENT_19_SELECT[$assessment->component_19] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_19_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>20</td>
                                    <td>{{ trans('crud.assessment.fields.component_20') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_20_helper') }}</td>
                                    <td>{{ ($assessment->component_20 ?? false) && isset(\App\Assessment::COMPONENT_20_SELECT[$assessment->component_20]) ? \App\Assessment::COMPONENT_20_SELECT[$assessment->component_20] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_20_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>21</td>
                                    <td>{{ trans('crud.assessment.fields.component_21') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_21_helper') }}</td>
                                    <td>{{ ($assessment->component_21 ?? false) && isset(\App\Assessment::COMPONENT_21_SELECT[$assessment->component_21]) ? \App\Assessment::COMPONENT_21_SELECT[$assessment->component_21] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_21_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>22</td>
                                    <td>{{ trans('crud.assessment.fields.component_22') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_22_helper') !!}</td>
                                    <td>{{ ($assessment->component_22 ?? false) && isset(\App\Assessment::COMPONENT_22_SELECT[$assessment->component_22]) ? \App\Assessment::COMPONENT_22_SELECT[$assessment->component_22] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_22_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>23</td>
                                    <td>{{ trans('crud.assessment.fields.component_23') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_23_helper') !!}</td>
                                    <td>{{ ($assessment->component_23 ?? false) && isset(\App\Assessment::COMPONENT_23_SELECT[$assessment->component_23]) ? \App\Assessment::COMPONENT_23_SELECT[$assessment->component_23] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_23_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>24</td>
                                    <td>{{ trans('crud.assessment.fields.component_24') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_24_helper') }}</td>
                                    <td>{{ ($assessment->component_24 ?? false) && isset(\App\Assessment::COMPONENT_24_SELECT[$assessment->component_24]) ? \App\Assessment::COMPONENT_24_SELECT[$assessment->component_24] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_24_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>25</td>
                                    <td>{{ trans('crud.assessment.fields.component_25') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_25_helper') !!}</td>
                                    <td>{{ ($assessment->component_25 ?? false) && isset(\App\Assessment::COMPONENT_25_SELECT[$assessment->component_25]) ? \App\Assessment::COMPONENT_25_SELECT[$assessment->component_25] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_25_links') as $key => $link)
                                                <li>
                                                    @if($link['path'] == 'dashboard')
                                                        <a href="{{ route('school.'.$link['path'], ['school_slug' => $school_slug]) }}"
                                                           target="_blank">
                                                            {{ $key }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                           target="_blank">
                                                            {{ $key }}
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>26</td>
                                    <td>{{ trans('crud.assessment.fields.component_26') }}</td>
                                    <td>{{ trans('crud.assessment.fields.component_26_helper') }}</td>
                                    <td>{{ ($assessment->component_26 ?? false) && isset(\App\Assessment::COMPONENT_26_SELECT[$assessment->component_26]) ? \App\Assessment::COMPONENT_26_SELECT[$assessment->component_26] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_26_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>27</td>
                                    <td>{{ trans('crud.assessment.fields.component_27') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_27_helper') !!}</td>
                                    <td>{{ ($assessment->component_27 ?? false) && isset(\App\Assessment::COMPONENT_27_SELECT[$assessment->component_27]) ? \App\Assessment::COMPONENT_27_SELECT[$assessment->component_27] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_27_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>28</td>
                                    <td>{{ trans('crud.assessment.fields.component_28') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_28_helper') !!}</td>
                                    <td>{{ ($assessment->component_28 ?? false) && isset(\App\Assessment::COMPONENT_28_SELECT[$assessment->component_28]) ? \App\Assessment::COMPONENT_28_SELECT[$assessment->component_28] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_28_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                </tr>

                                <tr>
                                    <td>29</td>
                                    <td>{{ trans('crud.assessment.fields.component_29') }}</td>
                                    <td>{!! trans('crud.assessment.fields.component_29_helper') !!}</td>
                                    <td>{{ ($assessment->component_29 ?? false) && isset(\App\Assessment::COMPONENT_29_SELECT[$assessment->component_29]) ? \App\Assessment::COMPONENT_29_SELECT[$assessment->component_29] : '' }}</td>
                                    <td>
                                        <ol>
                                            @foreach(trans('crud.assessment.fields.component_29_links') as $key => $link)
                                                <li>
                                                    <a href="{{ route('school.'.$link['path'].'.index', ['school_slug' => $school_slug]) }}"
                                                       target="_blank">
                                                        {{ $key }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ol>
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
