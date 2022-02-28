@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('crud.thisYearActionPlan.title') }}
        </div>

        <div class="card-body">
            <form method="get" action="{{ route("admin.this-year-action-plans.index") }}">
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.qualityReport.fields.school') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}"
                            name="school_id" id="school_id" required>
                        @foreach($schools as $id => $schoolName)
                            <option
                                value="{{ $id }}" {{ old('school_id') == $id ? 'selected' : '' }}>{{ $schoolName }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('school'))
                        <span class="text-danger">{{ $errors->first('school') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.qualityReport.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        {{ trans('global.view') }}
                    </button>
                </div>
            </form>

            @if($school)
                <div>
                    <div class="row mb-3 font-weight-bold">
                        <div class="col">
                            <div>RENCANA AKSI LINGKUNGAN JANGKA MENENGAH</div>
                            <div>
                                <span>{{ $school->name }}, {{ $school->address }}, {{ $school->city->name }}, {{ $school->city->province->name }}</span>
                            </div>
                            <div>TAHUN : {{ date('Y') }}</div>
                        </div>
                        <div class="col-4">
                            <div>&nbsp;</div>
                            <div>Tingkatan sekolah : {{ $school->level }}</div>
                            <div>Status : {{ $school->status }}</div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            @if($school->logo)
                                <img src="" alt="">
                            @else
                                <img src="" alt="Logo Sekolah">
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th rowspan="3" class="align-middle font-weight-normal">NO</th>
                                <th colspan="2" class="text-nowrap small font-weight-bold">KAJIAN LINGKUNGAN</th>
                                <th colspan="10" class="text-center text-nowrap small font-weight-bold">
                                    RENCANA AKSI KEGIATAN PENGELOLAAN FUNGSI LINGKUNGAN HIDUP DI SEKOLAH JANGKA MENENGAH
                                    (4 TH)
                                </th>
                                <th colspan="4" rowspan="2" class="text-center align-middle font-weight-bolder">AKSI
                                    SISTEM
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center text-nowrap">PEMETAAN KONDISI SEKOLAH</th>
                                <th rowspan="2" class="text-center align-middle text-nowrap">JENIS KEGIATAN</th>
                                <th colspan="4" class="text-center text-nowrap small font-weight-bold">TAHUN
                                    PELAKSANAAN
                                </th>
                                <th colspan="2" class="text-center text-nowrap small font-weight-bold">TARGET CAPAIAN
                                    KEGIATAN
                                </th>
                                <th rowspan="2" class="text-center align-middle small font-weight-bold">PENJAB POKJA
                                </th>
                                <th rowspan="2" class="text-center align-middle small font-weight-bold">SUMBER BIAYA
                                </th>
                                <th rowspan="2" class="text-center align-middle small font-weight-bold">PIHAK TERLIBAT
                                </th>
                            </tr>
                            <tr>
                                <th class="align-top text-nowrap font-weight-normal">POTENSI</th>
                                <th class="align-top text-nowrap font-weight-normal">MASALAH</th>
                                <th class="align-top text-nowrap font-weight-normal">TH 1</th>
                                <th class="align-top text-nowrap font-weight-normal">TH 2</th>
                                <th class="align-top text-nowrap font-weight-normal">TH 3</th>
                                <th class="align-top text-nowrap font-weight-normal">TH 4</th>
                                <th class="font-weight-normal">PERUBAHAN PERILAKU</th>
                                <th class="font-weight-normal">PERUBAHAN FISIK</th>
                                <th class="text-center align-top text-nowrap small font-weight-bold">EDIT</th>
                                <th class="text-center align-top text-nowrap small font-weight-bold">HAPUS</th>
                                <th class="text-center align-top text-nowrap small font-weight-bold">CETAK</th>
                                <th class="text-center align-top text-nowrap small font-weight-bold">SIMPAN</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

