@extends('layouts.school')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.view') }} {{ trans('crud.monitoringProgress.title_singular') }}
        </div>

        <div class="card-body">
            <form method="get"
                  action="{{ route("school.monitoring-progresses.index", ['school_slug' => $school_slug]) }}"
                  id="formView">

                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.monitoringProgress.fields.date') }}</label>
                    <input
                        class="form-control year {{ $errors->has('date') ? 'is-invalid' : '' }}"
                        type="text" name="date" autocomplete="off"
                        id="date" value="{{ request()->get('date', date('Y')) }}"
                        minlength="4" maxlength="4" data-toggle="datetimepicker" data-target="#date" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.monitoringProgress.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.workGroup.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id" required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', request()->get('aspect_id')) == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect'))
                        <span class="text-danger">{{ $errors->first('aspect') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.monitoringProgress.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            disabled name="work_group_id" id="work_group_id" required>
                        <option value
                                disabled {{ old('work_group_id', request()->get('work_group_id') ) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.monitoringProgress.fields.work_group_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-info" type="submit">
                        {{ trans('global.view') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Rencana Program (IPMLH)</th>
                        <th>Kondisi Awal (Rencana Kader)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($studies as $studyKey => $study)
                        <tr>
                            <td>{{ $studyKey+1 }}</td>
                            <td>
                                {{ $study->activity }}
                            </td>
                            <td>
                                <ul style="padding-left: 20px;">
                                    @foreach($study->studyWorkPrograms as $workProgramKey => $workProgram)
                                        {{--{{ $workProgramKey+1 }}.&nbsp;{{ $workProgram->plan }}<br>--}}
                                        <li>{{ $workProgram->plan }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Hasil Pelaksanaan (Pelaksanaan Kegiatan)</th>
                    </tr>
                    </thead>
                    <tbody>

                    @php($no = 1)
                    @foreach($studies as $studyKey => $study)
                        @foreach($study->studyWorkPrograms as $workProgramKey => $workProgram)
                            @foreach($workProgram->workProgramCadreActivities as $cadreActivityKey => $cadreActivity)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        {{ $cadreActivity->results }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Kendala (Pelaksanaan Kegiatan)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($no = 1)
                            @foreach($studies as $studyKey => $study)
                                @foreach($study->studyWorkPrograms as $workProgramKey => $workProgram)
                                    @foreach($workProgram->workProgramCadreActivities as $cadreActivityKey => $cadreActivity)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                {{ $cadreActivity->problem }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Rencana Tindak Lanjut (Penyelesaian)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($no = 1)
                            @foreach($studies as $studyKey => $study)
                                @foreach($study->studyWorkPrograms as $workProgramKey => $workProgram)
                                    @foreach($workProgram->workProgramCadreActivities as $cadreActivityKey => $cadreActivity)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>
                                                {{ $cadreActivity->plan }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $ = jQuery;

        $(function () {
            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');

            selectAspectId.change(function () {
                if (selectAspectId.val()) {
                    let newOption;

                    selectWorkGroupId.attr('disabled');

                    axios.post('{{ route('api.work-groups') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        aspect: selectAspectId.val(),
                    })
                        .then(function (response) {
                            selectWorkGroupId.empty();

                            let workGroupIdVal = Number("{{ old('work_group_id', request()->get('work_group_id')) }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkGroupId.append(newOption);
                            });

                            selectWorkGroupId.removeAttr('disabled');

                            if (workGroupIdVal) {
                                selectWorkGroupId.val(('{{ old('work_group_id', request()->get('work_group_id')) }}')).trigger('change');
                            }
                        })
                }
            });

            selectAspectId.val(('{{ old('aspect_id', request()->get('aspect_id')) }}')).trigger('change');
        });
    </script>
@endsection
