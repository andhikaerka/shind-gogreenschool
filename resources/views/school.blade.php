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

                        @if($school->logo)
                            <img src="{{ $school->logo->getUrl() }}" alt="" class="img-fluid d-flex mx-auto mb-5"
                                 style="max-width: 300px;">
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td>1</td>
                                    <td>Nama Sekolah</td>
                                    <td>{{ $school->name }}</td>
                                    <td rowspan="2">4</td>
                                    <td rowspan="2">Visi</td>
                                    <td rowspan="2">{{ $schoolProfile->vision }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Alamat</td>
                                    <td>{{ $school->address }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Kab/Kota</td>
                                    <td>{{ $school->city->name ?? '' }}</td>
                                    <td>5</td>
                                    <td>Status LH</td>
                                    <td>{{ $schoolProfile->environmental_status->name ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
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
                            {{ round($schoolProfile->cadres_count / $schoolProfile->total_students * 100) }}%
                        @elseif($schoolProfile->total_students > 1)
                            {{ round($schoolProfile->cadres_count / $schoolProfile->total_students * 100) }}%
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

        <div class="row mb-5" id="schools">
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
                            minlength="4" maxlength="4" data-toggle="datetimepicker" data-target="#year" required>
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
            <div class="col-12" style="height: 320px; overflow-y: scroll;">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Komponen</th>
                            <th scope="col">Indikator</th>
                            <th scope="col">Skor</th>
                            <th scope="col">Link</th>
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
                            <td>{{ $assessment->component_1 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_2 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_3 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_4 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_5 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_6 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_7 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_8 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_9 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_10 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_11 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_12 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_13 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_14 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_15 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_16 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_17 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_18 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_19 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_20 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_21 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_22 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_23 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_24 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_25 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_26 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_27 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_28 ?? 0 }}</td>
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
                            <td>{{ $assessment->component_29 ?? 0 }}</td>
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

                <i class="float-right">
                    Catatan: Sumber berdasarkan capaian indikator dan komponen dalam Permen LH 52 dan 53
                </i>
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
                format: 'YYYY'
            });

            $('span.select2.select2-container.select2-container--bootstrap4').addClass('my-1 mr-sm-5');

            let languages = {
                'id': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json',
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
            };
            $('table#datatable-Assessment').DataTable({
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
            });
        });
    </script>
@endsection
