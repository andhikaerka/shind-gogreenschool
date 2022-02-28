@extends('layouts.school')

@section('title')
    Penilaian Akhir Periode
@endsection

@section('content-header')
    Penilaian Akhir Periode
@endsection

@section('content')
    <div class="card">
        <div class="card-header border-bottom-0">
            Penilaian
        </div>

        <div class="card-body border-top-0">
            <p class="card-text">
                Merupakan kegiatan sekolah yang mengacu terhadap peningkatan fungsi lingkungan hidup secara detail dari
                komponen dan indikator yang sesuai dengan ketentuan resmi Pemerintah dalam program sekolah Adiwiyata
            </p>

            <form action="" method="get" class="mb-3">
                <div class="row form-row d-flex justify-content-between">
                    <div class="col mr-sm-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label
                                    class="{{ app()->environment() == 'production' ? 'required' : '' }} input-group-text bg-transparent border-0"
                                    for="year">{{ trans('crud.schoolProfile.fields.year') }}&nbsp;:</label>
                            </div>
                            <input
                                class="form-control year rounded-left {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                type="text" name="year" autocomplete="off"
                                id="year" value="{{ request()->get('year', date('Y')) }}"
                                minlength="4" maxlength="4" data-toggle="datetimepicker"
                                data-target="#year" {{ app()->environment() == 'production' ? 'required' : '' }}>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    {{ trans('global.view') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text bg-transparent border-0">Total Skor&nbsp;:</label>
                            </div>
                            <div class="input-group-append">
                                <div class="input-group-text bg-transparent border-0" id="recordsScore">
                                    {{ $assessment->score ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('school.assessments.update', ['school_slug' => $school_slug]) }}" method="post">
                @csrf
                <input type="hidden" name="year" value="{{ request()->get('year', date('Y')) }}">
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
                                Rencana Aksi & Kegiatan pengelolaan lingkungan hidup di sekolah sesuai dengan EDS dan
                                Kajian
                                Lingkungan Sekolah
                            </td>
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_1') ? 'is-invalid' : '' }}"
                                            name="component_1"
                                            id="component_1" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_1', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_1_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_1', ($assessment->component_1 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_1'))
                                            <span class="text-danger">{{ $errors->first('component_1') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_1 ?? false) && isset(\App\Assessment::COMPONENT_1_SELECT[$assessment->component_1]) ? \App\Assessment::COMPONENT_1_SELECT[$assessment->component_1] : '' }}</td>
                                <td>{{ $assessment->component_1 ?? '' }}</td>
                            @endif
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
                                Penyusunan Aksi dan Kegiatan Pengelolaan lingkungan hidup di sekolah melibatkan berbagai
                                pihak sekolah
                            </td>
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_2') ? 'is-invalid' : '' }}"
                                            name="component_2"
                                            id="component_2" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_2', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_2_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_2', ($assessment->component_2 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_2'))
                                            <span class="text-danger">{{ $errors->first('component_2') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_2 ?? false) && isset(\App\Assessment::COMPONENT_2_SELECT[$assessment->component_2]) ? \App\Assessment::COMPONENT_2_SELECT[$assessment->component_2] : '' }}</td>
                                <td>{{ $assessment->component_2 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_3') ? 'is-invalid' : '' }}"
                                            name="component_3"
                                            id="component_3" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_3', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_3_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_3', ($assessment->component_3 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_3'))
                                            <span class="text-danger">{{ $errors->first('component_3') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_3 ?? false) && isset(\App\Assessment::COMPONENT_3_SELECT[$assessment->component_3]) ? \App\Assessment::COMPONENT_3_SELECT[$assessment->component_3] : '' }}</td>
                                <td>{{ $assessment->component_3 ?? '' }}</td>
                            @endif
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
                                Gerakan kegiatan pengelolaan lingkungan sekolah terintegrasi datam proses betajar sesuai
                                aspek penerapan bidang LH di Sekolah
                            </td>
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_4') ? 'is-invalid' : '' }}"
                                            name="component_4"
                                            id="component_4" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_4', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_4_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_4', ($assessment->component_4 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_4'))
                                            <span class="text-danger">{{ $errors->first('component_4') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_4 ?? false) && isset(\App\Assessment::COMPONENT_4_SELECT[$assessment->component_4]) ? \App\Assessment::COMPONENT_4_SELECT[$assessment->component_4] : '' }}</td>
                                <td>{{ $assessment->component_4 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_5') ? 'is-invalid' : '' }}"
                                            name="component_5"
                                            id="component_5" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_5', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_5_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_5', ($assessment->component_5 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_5'))
                                            <span class="text-danger">{{ $errors->first('component_5') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_5 ?? false) && isset(\App\Assessment::COMPONENT_5_SELECT[$assessment->component_5]) ? \App\Assessment::COMPONENT_5_SELECT[$assessment->component_5] : '' }}</td>
                                <td>{{ $assessment->component_5 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_6') ? 'is-invalid' : '' }}"
                                            name="component_6"
                                            id="component_6" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_6', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_6_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_6', ($assessment->component_6 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_6'))
                                            <span class="text-danger">{{ $errors->first('component_6') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_6 ?? false) && isset(\App\Assessment::COMPONENT_6_SELECT[$assessment->component_6]) ? \App\Assessment::COMPONENT_6_SELECT[$assessment->component_6] : '' }}</td>
                                <td>{{ $assessment->component_6 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_6') ? 'is-invalid' : '' }}"
                                            name="component_7"
                                            id="component_7" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_7', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_7_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_7', ($assessment->component_7 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_7'))
                                            <span class="text-danger">{{ $errors->first('component_7') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_7 ?? false) && isset(\App\Assessment::COMPONENT_7_SELECT[$assessment->component_7]) ? \App\Assessment::COMPONENT_7_SELECT[$assessment->component_7] : '' }}</td>
                                <td>{{ $assessment->component_7 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_8') ? 'is-invalid' : '' }}"
                                            name="component_8"
                                            id="component_8" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_8', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_8_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_8', ($assessment->component_8 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_8'))
                                            <span class="text-danger">{{ $errors->first('component_8') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_8 ?? false) && isset(\App\Assessment::COMPONENT_8_SELECT[$assessment->component_8]) ? \App\Assessment::COMPONENT_8_SELECT[$assessment->component_8] : '' }}</td>
                                <td>{{ $assessment->component_8 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_9') ? 'is-invalid' : '' }}"
                                            name="component_9"
                                            id="component_9" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_9', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_9_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_9', ($assessment->component_9 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_9'))
                                            <span class="text-danger">{{ $errors->first('component_9') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_9 ?? false) && isset(\App\Assessment::COMPONENT_9_SELECT[$assessment->component_9]) ? \App\Assessment::COMPONENT_9_SELECT[$assessment->component_9] : '' }}</td>
                                <td>{{ $assessment->component_9 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_10') ? 'is-invalid' : '' }}"
                                            name="component_10"
                                            id="component_10" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_10', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_10_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_10', ($assessment->component_10 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_10'))
                                            <span class="text-danger">{{ $errors->first('component_10') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_10 ?? false) && isset(\App\Assessment::COMPONENT_10_SELECT[$assessment->component_10]) ? \App\Assessment::COMPONENT_10_SELECT[$assessment->component_10] : '' }}</td>
                                <td>{{ $assessment->component_10 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_11') ? 'is-invalid' : '' }}"
                                            name="component_11"
                                            id="component_11" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_11', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_11_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_11', ($assessment->component_11 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_11'))
                                            <span class="text-danger">{{ $errors->first('component_11') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_11 ?? false) && isset(\App\Assessment::COMPONENT_11_SELECT[$assessment->component_11]) ? \App\Assessment::COMPONENT_11_SELECT[$assessment->component_11] : '' }}</td>
                                <td>{{ $assessment->component_11 ?? '' }}</td>
                            @endif
                            <td></td>
                        </tr>

                        <tr>
                            <td>11</td>
                            <td>
                                Upaya menghijaukan sekolah (Pembibitan-penanaman dan pemeliharaan /panen)
                            </td>
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_12') ? 'is-invalid' : '' }}"
                                            name="component_12"
                                            id="component_12" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_12', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_12_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_12', ($assessment->component_12 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_12'))
                                            <span class="text-danger">{{ $errors->first('component_12') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_12 ?? false) && isset(\App\Assessment::COMPONENT_12_SELECT[$assessment->component_12]) ? \App\Assessment::COMPONENT_12_SELECT[$assessment->component_12] : '' }}</td>
                                <td>{{ $assessment->component_12 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_13') ? 'is-invalid' : '' }}"
                                            name="component_13"
                                            id="component_13" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_13', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_13_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_13', ($assessment->component_13 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_13'))
                                            <span class="text-danger">{{ $errors->first('component_13') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_13 ?? false) && isset(\App\Assessment::COMPONENT_13_SELECT[$assessment->component_13]) ? \App\Assessment::COMPONENT_13_SELECT[$assessment->component_13] : '' }}</td>
                                <td>{{ $assessment->component_13 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_13') ? 'is-invalid' : '' }}"
                                            name="component_14"
                                            id="component_14" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_14', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_14_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_14', ($assessment->component_14 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_14'))
                                            <span class="text-danger">{{ $errors->first('component_14') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_14 ?? false) && isset(\App\Assessment::COMPONENT_14_SELECT[$assessment->component_14]) ? \App\Assessment::COMPONENT_14_SELECT[$assessment->component_14] : '' }}</td>
                                <td>{{ $assessment->component_14 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_15') ? 'is-invalid' : '' }}"
                                            name="component_15"
                                            id="component_15" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_15', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_15_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_15', ($assessment->component_15 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_15'))
                                            <span class="text-danger">{{ $errors->first('component_15') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_15 ?? false) && isset(\App\Assessment::COMPONENT_15_SELECT[$assessment->component_15]) ? \App\Assessment::COMPONENT_15_SELECT[$assessment->component_15] : '' }}</td>
                                <td>{{ $assessment->component_15 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_16') ? 'is-invalid' : '' }}"
                                            name="component_16"
                                            id="component_16" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_16', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_16_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_16', ($assessment->component_16 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_16'))
                                            <span class="text-danger">{{ $errors->first('component_16') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_16 ?? false) && isset(\App\Assessment::COMPONENT_16_SELECT[$assessment->component_16]) ? \App\Assessment::COMPONENT_16_SELECT[$assessment->component_16] : '' }}</td>
                                <td>{{ $assessment->component_16 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_17') ? 'is-invalid' : '' }}"
                                            name="component_17"
                                            id="component_17" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_17', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_17_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_17', ($assessment->component_17 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_17'))
                                            <span class="text-danger">{{ $errors->first('component_17') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_17 ?? false) && isset(\App\Assessment::COMPONENT_17_SELECT[$assessment->component_17]) ? \App\Assessment::COMPONENT_17_SELECT[$assessment->component_17] : '' }}</td>
                                <td>{{ $assessment->component_17 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_18') ? 'is-invalid' : '' }}"
                                            name="component_18"
                                            id="component_18" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_18', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_18_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_18', ($assessment->component_18 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_18'))
                                            <span class="text-danger">{{ $errors->first('component_18') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_18 ?? false) && isset(\App\Assessment::COMPONENT_18_SELECT[$assessment->component_18]) ? \App\Assessment::COMPONENT_18_SELECT[$assessment->component_18] : '' }}</td>
                                <td>{{ $assessment->component_18 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_19') ? 'is-invalid' : '' }}"
                                            name="component_19"
                                            id="component_19" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_19', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_19_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_19', ($assessment->component_19 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_19'))
                                            <span class="text-danger">{{ $errors->first('component_19') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_19 ?? false) && isset(\App\Assessment::COMPONENT_19_SELECT[$assessment->component_19]) ? \App\Assessment::COMPONENT_19_SELECT[$assessment->component_19] : '' }}</td>
                                <td>{{ $assessment->component_19 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_20') ? 'is-invalid' : '' }}"
                                            name="component_20"
                                            id="component_20" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_20', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_20_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_20', ($assessment->component_20 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_20'))
                                            <span class="text-danger">{{ $errors->first('component_20') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_20 ?? false) && isset(\App\Assessment::COMPONENT_20_SELECT[$assessment->component_20]) ? \App\Assessment::COMPONENT_20_SELECT[$assessment->component_20] : '' }}</td>
                                <td>{{ $assessment->component_20 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_20') ? 'is-invalid' : '' }}"
                                            name="component_21"
                                            id="component_21" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_21', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_21_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_21', ($assessment->component_21 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_21'))
                                            <span class="text-danger">{{ $errors->first('component_21') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_21 ?? false) && isset(\App\Assessment::COMPONENT_21_SELECT[$assessment->component_21]) ? \App\Assessment::COMPONENT_21_SELECT[$assessment->component_21] : '' }}</td>
                                <td>{{ $assessment->component_21 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_22') ? 'is-invalid' : '' }}"
                                            name="component_22"
                                            id="component_22" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_22', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_22_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_22', ($assessment->component_22 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_22'))
                                            <span class="text-danger">{{ $errors->first('component_22') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_22 ?? false) && isset(\App\Assessment::COMPONENT_22_SELECT[$assessment->component_22]) ? \App\Assessment::COMPONENT_22_SELECT[$assessment->component_22] : '' }}</td>
                                <td>{{ $assessment->component_22 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_23') ? 'is-invalid' : '' }}"
                                            name="component_23"
                                            id="component_23" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_23', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_23_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_23', ($assessment->component_23 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_23'))
                                            <span class="text-danger">{{ $errors->first('component_23') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_23 ?? false) && isset(\App\Assessment::COMPONENT_23_SELECT[$assessment->component_23]) ? \App\Assessment::COMPONENT_23_SELECT[$assessment->component_23] : '' }}</td>
                                <td>{{ $assessment->component_23 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_24') ? 'is-invalid' : '' }}"
                                            name="component_24"
                                            id="component_24" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_24', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_24_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_24', ($assessment->component_24 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_24'))
                                            <span class="text-danger">{{ $errors->first('component_24') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_24 ?? false) && isset(\App\Assessment::COMPONENT_24_SELECT[$assessment->component_24]) ? \App\Assessment::COMPONENT_24_SELECT[$assessment->component_24] : '' }}</td>
                                <td>{{ $assessment->component_24 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_25') ? 'is-invalid' : '' }}"
                                            name="component_25"
                                            id="component_25" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_25', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_25_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_25', ($assessment->component_25 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_25'))
                                            <span class="text-danger">{{ $errors->first('component_25') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_25 ?? false) && isset(\App\Assessment::COMPONENT_25_SELECT[$assessment->component_25]) ? \App\Assessment::COMPONENT_25_SELECT[$assessment->component_25] : '' }}</td>
                                <td>{{ $assessment->component_25 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_26') ? 'is-invalid' : '' }}"
                                            name="component_26"
                                            id="component_26" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_26', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_26_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_26', ($assessment->component_26 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_26'))
                                            <span class="text-danger">{{ $errors->first('component_26') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_26 ?? false) && isset(\App\Assessment::COMPONENT_26_SELECT[$assessment->component_26]) ? \App\Assessment::COMPONENT_26_SELECT[$assessment->component_26] : '' }}</td>
                                <td>{{ $assessment->component_26 ?? '' }}</td>
                            @endif
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
                            @if(auth()->check() && (auth()->user()->isAdmin || auth()->user()->isOperator))
                                <td colspan="2">
                                    <div class="form-group">
                                        <select
                                            class="form-control {{ $errors->has('component_27') ? 'is-invalid' : '' }}"
                                            name="component_27"
                                            id="component_27" {{ app()->environment() == 'production' ? 'required' : '' }}>
                                            <option value=""
                                                    disabled {{ old('component_27', '') == '' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach(App\Assessment::COMPONENT_27_SELECT as $key => $label)
                                                <option
                                                    value="{{ $key }}" {{ old('component_27', ($assessment->component_27 ?? '')) == $key ? 'selected' : '' }}>
                                                    {{ $label }} (Nilai: {{ $key }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('component_27'))
                                            <span class="text-danger">{{ $errors->first('component_27') }}</span>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td>{{ ($assessment->component_27 ?? false) && isset(\App\Assessment::COMPONENT_27_SELECT[$assessment->component_27]) ? \App\Assessment::COMPONENT_27_SELECT[$assessment->component_27] : '' }}</td>
                                <td>{{ $assessment->component_27 ?? '' }}</td>
                            @endif
                            <td>
                                <a href="{{ route('school.evaluations.index', ['school_slug' => $school_slug]) }}"
                                   target="_blank">
                                    Evaluasi Kegiatan
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-info">
                        Simpan & Kirim
                    </button>
                    <a href="{{ route('school.assessments.print', ['school_slug' => $school_slug]) }}"
                       class="btn btn-primary" target="_blank">
                        Cetak
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
