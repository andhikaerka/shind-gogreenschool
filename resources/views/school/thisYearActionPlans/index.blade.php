@extends('layouts.school')

@section('title')
    {{ trans('global.list') }} {{ trans('crud.thisYearActionPlan.title_singular') }} - {{ trans('panel.site_title') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('crud.thisYearActionPlan.title') }}
        </div>

        <div class="card-body">
            <form id="formPrint" action="" method="get" class="mb-3 form-inline">
                <div class="row form-row">
                    <div class="col mr-sm-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="required input-group-text bg-transparent border-0"
                                       for="year">{{ trans('crud.schoolProfile.fields.year') }}&nbsp;:</label>
                            </div>
                            <input
                                class="form-control year rounded-left {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                type="text" name="year" autocomplete="off"
                                id="year" value="{{ request()->get('year', date('Y')) }}"
                                minlength="4" maxlength="4" data-toggle="datetimepicker" data-target="#year" required>
                            <div class="input-group-append">
                                <button id="btnView" class="btn btn-outline-secondary" type="button">
                                    {{ trans('global.view') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="btnPrint" class="btn btn-outline-success" type="button">
                    {{ trans('global.datatables.print') }}
                </button>
            </form>

            @if($school)
                <div>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td colspan="6" class="font-weight-bold">
                                    RENCANA AKSI LINGKUNGAN JANGKA MENENGAH (1 TH)
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 107px;">Nama Sekolah</td>
                                <td style="width: 14px;">:</td>
                                <td>{{ $school->name }}</td>
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

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th rowspan="3" class="align-middle font-weight-normal">
                                    NO
                                </th>
                                <th colspan="2" rowspan="2" class="small font-weight-bold text-center align-middle">
                                    PEMETAAN
                                </th>
                                <th rowspan="3" class="align-middle font-weight-normal">
                                    KATEGORI
                                    <br>8 SNP
                                </th>
                                <th colspan="18" class="text-center text-nowrap small font-weight-bold">
                                    RENCANA AKSI KEGIATAN PENGELOLAAN DAN PERLINDUNGAN LH DI SEKOLAH SETAHUN
                                </th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="text-center align-middle text-nowrap">JENIS KEGIATAN</th>
                                <th colspan="12" class="text-center text-nowrap small font-weight-bold">
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
                                <th class="align-top text-nowrap font-weight-normal">POTENSI</th>
                                <th class="align-top text-nowrap font-weight-normal">MASALAH</th>
                                <th class="align-top text-nowrap font-weight-normal">1</th>
                                <th class="align-top text-nowrap font-weight-normal">2</th>
                                <th class="align-top text-nowrap font-weight-normal">3</th>
                                <th class="align-top text-nowrap font-weight-normal">4</th>
                                <th class="align-top text-nowrap font-weight-normal">5</th>
                                <th class="align-top text-nowrap font-weight-normal">6</th>
                                <th class="align-top text-nowrap font-weight-normal">7</th>
                                <th class="align-top text-nowrap font-weight-normal">8</th>
                                <th class="align-top text-nowrap font-weight-normal">9</th>
                                <th class="align-top text-nowrap font-weight-normal">10</th>
                                <th class="align-top text-nowrap font-weight-normal">11</th>
                                <th class="align-top text-nowrap font-weight-normal">12</th>
                                <th class="font-weight-normal">PERILAKU</th>
                                <th class="font-weight-normal">PHISIK</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($disasters as $key => $environmentalIssue)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $environmentalIssue->potential ?? '' }}</td>
                                    <td>{{ $environmentalIssue->threat ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $environmentalIssue->anticipation ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach($globalEnvironmentalIssues as $key => $environmentalIssue)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $environmentalIssue->potency ?? '' }}</td>
                                    <td>{{ $environmentalIssue->problem ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $environmentalIssue->anticipation ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach($nasionalEnvironmentalIssues as $key => $environmentalIssue)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $environmentalIssue->potency ?? '' }}</td>
                                    <td>{{ $environmentalIssue->problem ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $environmentalIssue->anticipation ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach($daerahEnvironmentalIssues as $key => $environmentalIssue)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $environmentalIssue->potency ?? '' }}</td>
                                    <td>{{ $environmentalIssue->problem ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $environmentalIssue->anticipation ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach($lokalEnvironmentalIssues as $key => $environmentalIssue)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $environmentalIssue->potency ?? '' }}</td>
                                    <td>{{ $environmentalIssue->problem ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $environmentalIssue->anticipation ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach($sampahStudies as $key => $study)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $study->potential ?? '' }}</td>
                                    <td>{{ $study->problem ?? '' }}</td>
                                    <td>{{ $study->snp_category->name ?? '' }}</td>
                                    <td>{!! $study->activities ?? '' !!}</td>
                                    @for($i = 1; $i <= ($study->period < 12 ? $study->period : 12); $i++)
                                        <td>X</td>
                                    @endfor
                                    @for($i = (($study->period < 12 ? $study->period : 12) + 1); $i <= 12; $i++)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td>{{ $study->behavioral ?? '' }}</td>
                                    <td>{{ $study->physical ?? '' }}</td>
                                    <td>{{ $study->source ?? '' }}</td>
                                    <td>
                                        {{ join(',', $study->team_statuses()->pluck('name')->toArray()) }}
                                    </td>
                                    <td>{{ $study->partner->name ?? '' }}</td>
                                </tr>
                            @endforeach
                            @foreach($energiStudies as $key => $study)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $study->potential ?? '' }}</td>
                                    <td>{{ $study->problem ?? '' }}</td>
                                    <td>{{ $study->snp_category->name ?? '' }}</td>
                                    <td>{!! $study->activities ?? '' !!}</td>
                                    @for($i = 1; $i <= ($study->period < 12 ? $study->period : 12); $i++)
                                        <td>X</td>
                                    @endfor
                                    @for($i = (($study->period < 12 ? $study->period : 12) + 1); $i <= 12; $i++)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td>{{ $study->behavioral ?? '' }}</td>
                                    <td>{{ $study->physical ?? '' }}</td>
                                    <td>{{ $study->source ?? '' }}</td>
                                    <td>
                                        {{ join(',', $study->team_statuses()->pluck('name')->toArray()) }}
                                    </td>
                                    <td>{{ $study->partner->name ?? '' }}</td>
                                </tr>
                            @endforeach
                            @foreach($kehatiStudies as $key => $study)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $study->potential ?? '' }}</td>
                                    <td>{{ $study->problem ?? '' }}</td>
                                    <td>{{ $study->snp_category->name ?? '' }}</td>
                                    <td>{!! $study->activities ?? '' !!}</td>
                                    @for($i = 1; $i <= ($study->period < 12 ? $study->period : 12); $i++)
                                        <td>X</td>
                                    @endfor
                                    @for($i = (($study->period < 12 ? $study->period : 12) + 1); $i <= 12; $i++)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td>{{ $study->behavioral ?? '' }}</td>
                                    <td>{{ $study->physical ?? '' }}</td>
                                    <td>{{ $study->source ?? '' }}</td>
                                    <td>
                                        {{ join(',', $study->team_statuses()->pluck('name')->toArray()) }}
                                    </td>
                                    <td>{{ $study->partner->name ?? '' }}</td>
                                </tr>
                            @endforeach
                            @foreach($airStudies as $key => $study)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $study->potential ?? '' }}</td>
                                    <td>{{ $study->problem ?? '' }}</td>
                                    <td>{{ $study->snp_category->name ?? '' }}</td>
                                    <td>{!! $study->activities ?? '' !!}</td>
                                    @for($i = 1; $i <= ($study->period < 12 ? $study->period : 12); $i++)
                                        <td>X</td>
                                    @endfor
                                    @for($i = (($study->period < 12 ? $study->period : 12) + 1); $i <= 12; $i++)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td>{{ $study->behavioral ?? '' }}</td>
                                    <td>{{ $study->physical ?? '' }}</td>
                                    <td>{{ $study->source ?? '' }}</td>
                                    <td>
                                        {{ join(',', $study->team_statuses()->pluck('name')->toArray()) }}
                                    </td>
                                    <td>{{ $study->partner->name ?? '' }}</td>
                                </tr>
                            @endforeach
                            @foreach($kantinStudies as $key => $study)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $study->potential ?? '' }}</td>
                                    <td>{{ $study->problem ?? '' }}</td>
                                    <td>{{ $study->snp_category->name ?? '' }}</td>
                                    <td>{!! $study->activities ?? '' !!}</td>
                                    @for($i = 1; $i <= ($study->period < 12 ? $study->period : 12); $i++)
                                        <td>X</td>
                                    @endfor
                                    @for($i = (($study->period < 12 ? $study->period : 12) + 1); $i <= 12; $i++)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td>{{ $study->behavioral ?? '' }}</td>
                                    <td>{{ $study->physical ?? '' }}</td>
                                    <td>{{ $study->source ?? '' }}</td>
                                    <td>
                                        {{ join(',', $study->team_statuses()->pluck('name')->toArray()) }}
                                    </td>
                                    <td>{{ $study->partner->name ?? '' }}</td>
                                </tr>
                            @endforeach
                            {{-- @foreach($budgetPlans as $key => $budgetPlan)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $budgetPlan->potential ?? '' }}</td>
                                    <td>{{ $budgetPlan->threat ?? '' }}</td>
                                    <td>{{ $budgetPlan->snp_category->name ?? '' }}</td>
                                    <td>?</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach($partners as $key => $partner)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $partner->potential ?? '' }}</td>
                                    <td>{{ $partner->threat ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>?</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endforeach
                            @foreach($workPrograms as $key => $workProgram)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $loop->count }}">{{ $no++ }}</td>
                                    @endif
                                    <td>{{ $workProgram->potential ?? '' }}</td>
                                    <td>{{ $workProgram->threat ?? '' }}</td>
                                    <td>{{ $workProgram->study->snp_category->name ?? '' }}</td>
                                    <td>{!! $workProgram->plan ?? '' !!}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>{{ $workProgram->study->behavioral ?? '' }}</td>
                                    <td>{{ $workProgram->study->physical ?? '' }}</td>
                                    <td>&nbsp;</td>
                                    <td>{!! $workProgram->tutor !!}</td>
                                    <td>{{ $workProgram->study->partner->name ?? '' }}</td>
                                </tr>
                            @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            const formPrint = $('#formPrint');

            $('#btnView').click(function () {
                formPrint.attr('action', '{{ route('school.this-year-action-plans.index', $school_slug) }}');
                formPrint.attr('target', '');
                formPrint.submit();
            });

            $('#btnPrint').click(function () {
                formPrint.attr('action', '{{ route('school.this-year-action-plans.print', $school_slug) }}');
                formPrint.attr('target', '_blank');
                formPrint.submit();
            })
        })
    </script>
@endsection
