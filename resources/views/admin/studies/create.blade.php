@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.study.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.studies.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.qualityReport.fields.school') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}"
                            name="school_id" id="school_id" required>
                        @foreach($schools as $id => $school)
                            <option
                                value="{{ $id }}" {{ old('school_id') == $id ? 'selected' : '' }}>{{ $school }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('school'))
                        <span class="text-danger">{{ $errors->first('school') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.qualityReport.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="quality_report_id">{{ trans('crud.study.fields.quality_report') }}</label>
                    <select class="form-control select2 {{ $errors->has('quality_report') ? 'is-invalid' : '' }}"
                            name="quality_report_id" id="quality_report_id"
                            required disabled>
                        @foreach($quality_reports as $id => $quality_report)
                            <option
                                value="{{ $id }}" {{ old('quality_report_id') == $id ? 'selected' : '' }}>{{ $quality_report }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('quality_report'))
                        <span class="text-danger">{{ $errors->first('quality_report') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.quality_report_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="work_group_id">{{ trans('crud.study.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            required disabled>
                        @foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ old('work_group_id') == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="potential">{{ trans('crud.study.fields.potential') }}</label>
                    <textarea class="form-control {{ $errors->has('potential') ? 'is-invalid' : '' }}" name="potential"
                              id="potential" required>{{ old('potential') }}</textarea>
                    @if($errors->has('potential'))
                        <span class="text-danger">{{ $errors->first('potential') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.potential_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="problem">{{ trans('crud.study.fields.problem') }}</label>
                    <textarea class="form-control {{ $errors->has('problem') ? 'is-invalid' : '' }}" name="problem"
                              id="problem" required>{{ old('problem') }}</textarea>
                    @if($errors->has('problem'))
                        <span class="text-danger">{{ $errors->first('problem') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.problem_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="activity">{{ trans('crud.study.fields.activity') }}</label>
                    <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity"
                              id="activity" required>{{ old('activity') }}</textarea>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.activity_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="behavioral">{{ trans('crud.study.fields.behavioral') }}</label>
                    <textarea class="form-control {{ $errors->has('behavioral') ? 'is-invalid' : '' }}"
                              name="behavioral" id="behavioral" required>{{ old('behavioral') }}</textarea>
                    @if($errors->has('behavioral'))
                        <span class="text-danger">{{ $errors->first('behavioral') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.behavioral_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="physical">{{ trans('crud.study.fields.physical') }}</label>
                    <textarea class="form-control {{ $errors->has('physical') ? 'is-invalid' : '' }}" name="physical"
                              id="physical" required>{{ old('physical') }}</textarea>
                    @if($errors->has('physical'))
                        <span class="text-danger">{{ $errors->first('physical') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.physical_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="kbm">{{ trans('crud.study.fields.kbm') }}</label>
                    <textarea class="form-control {{ $errors->has('kbm') ? 'is-invalid' : '' }}" name="kbm" id="kbm"
                              required>{{ old('kbm') }}</textarea>
                    @if($errors->has('kbm'))
                        <span class="text-danger">{{ $errors->first('kbm') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.kbm_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="artwork">{{ trans('crud.study.fields.artwork') }}</label>
                    <textarea class="form-control {{ $errors->has('artwork') ? 'is-invalid' : '' }}" name="artwork"
                              id="artwork" required>{{ old('artwork') }}</textarea>
                    @if($errors->has('artwork'))
                        <span class="text-danger">{{ $errors->first('artwork') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.artwork_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="period">{{ trans('crud.study.fields.period') }}</label>
                    <select class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" name="period"
                            id="period" required>
                        <option value
                                disabled {{ old('period', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Study::PERIOD_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('period', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('period'))
                        <span class="text-danger">{{ $errors->first('period') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.period_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="source">{{ trans('crud.study.fields.source') }}</label>
                    <select class="form-control select2-tags {{ $errors->has('source') ? 'is-invalid' : '' }}" name="source"
                            id="source" required>
                        <option value
                                disabled {{ old('source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Study::SOURCE_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('source', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('source'))
                        <span class="text-danger">{{ $errors->first('source') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.source_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="cost">{{ trans('crud.study.fields.cost') }}</label>
                    <input class="form-control {{ $errors->has('cost') ? 'is-invalid' : '' }}" type="number" name="cost"
                           id="cost" value="{{ old('cost', '') }}" step="1" min="0" required>
                    @if($errors->has('cost'))
                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.cost_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="partner_id">{{ trans('crud.study.fields.partner') }}</label>
                    <select class="form-control select2 {{ $errors->has('partner') ? 'is-invalid' : '' }}"
                            name="partner_id" id="partner_id" required disabled>
                        @foreach($partners as $id => $partner)
                            <option
                                value="{{ $id }}" {{ old('partner_id') == $id ? 'selected' : '' }}>{{ $partner }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('partner'))
                        <span class="text-danger">{{ $errors->first('partner') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.partner_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            const selectSchoolId = $('select#school_id');
            const selectQualityReportId = $('select#quality_report_id');
            const selectWorkGroupId = $('select#work_group_id');
            const selectPartnerId = $('select#partner_id');

            let newOption;

            selectSchoolId.change(function () {
                setTimeout(function () {
                    axios.post('{{ route('api.quality-reports') }}', {
                        school: selectSchoolId.val(),
                    })
                        .then(function (response) {
                            selectQualityReportId.empty();

                            let qualityReportId = Number("{{ old('quality_report_id', '') }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === qualityReportId), (data.id === qualityReportId));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectQualityReportId.append(newOption);
                            });

                            selectQualityReportId.removeAttr('disabled');
                        });
                }, 500);

                setTimeout(function () {
                    axios.post('{{ route('api.work-groups') }}', {
                        school: selectSchoolId.val(),
                    })
                        .then(function (response) {
                            selectWorkGroupId.empty();

                            let workGroupIdVal = Number("{{ old('work_group_id', '') }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === workGroupIdVal), (data.id === workGroupIdVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkGroupId.append(newOption);
                            });

                            selectWorkGroupId.removeAttr('disabled');
                        });
                }, 500);

                setTimeout(function () {
                    axios.post('{{ route('api.partners') }}', {
                        school: selectSchoolId.val(),
                    })
                        .then(function (response) {
                            selectPartnerId.empty();

                            let partnerIdVal = Number("{{ old('partner_id', '') }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === partnerIdVal), (data.id === partnerIdVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectPartnerId.append(newOption);
                            });

                            selectPartnerId.removeAttr('disabled');
                        })
                }, 500)
            });

            selectSchoolId.val(Number('{{ old('school_id', null) }}')).trigger('change');
        });
    </script>
@endsection
