@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.recommendation.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.recommendations.store", ['school_slug' => $school_slug]) }}"
                  id="formCreate">
                @csrf

                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.innovation.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group_id') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            {{ app()->environment() == 'production' ? 'required' : '' }} disabled="disabled">
                    </select>
                    @if($errors->has('work_group_id'))
                        <span class="text-danger">{{ $errors->first('work_group_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.work_group_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="work_program_id">Nama Proker</label>
                    <select class="form-control {{ $errors->has('work_program_id') ? 'is-invalid' : '' }}"
                            name="work_program_id" id="work_program_id" required>
                    </select>
                    @if($errors->has('work_program_id'))
                        <span class="text-danger">{{ $errors->first('work_program_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required"
                           for="cadre_activity_id">Kegiatan</label>
                    <select class="form-control select2 {{ $errors->has('cadre_activity_id') ? 'is-invalid' : '' }}"
                            name="cadre_activity_id" id="cadre_activity_id" required="required" disabled="disabled">
                        <option value="" selected disabled>{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if($errors->has('cadre_activity_id'))
                        <span class="text-danger">{{ $errors->first('cadre_activity_id') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required" for="recommendation">Rekomendasi</label>
                    <textarea class="form-control {{ $errors->has('recommendation') ? 'is-invalid' : '' }}"
                              name="recommendation"
                              id="recommendation" required>{{ old('recommendation') }}</textarea>
                    @if($errors->has('recommendation'))
                        <span class="text-danger">{{ $errors->first('recommendation') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="hidden" name="add_more" id="add_more" value="{{ old('add_more', 0) }}">
                    <button class="btn btn-warning" type="button" onclick="$('#add_more').val(1); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.add') }} {{ trans('crud.recommendation.title_singular') }}?
                    </button>
                    <button class="btn btn-danger" type="button" onclick="$('#add_more').val(0); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $ = jQuery;

        $(function () {
            const selectWorkProgramId = $('select#work_program_id');
            const selectCadreActivityId = $('select#cadre_activity_id');
            const selectWorkGroupId = $('select#work_group_id');

            let newOption;

            axios.post('{{ route('api.work-groups') }}', {
                school: '{{ auth()->user()->isSTC }}'
            }).then(function (response) {
                selectWorkGroupId.empty();

                let workGroupIdVal = Number("{{ old('work_group_id', '') }}");

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
                    selectWorkGroupId.val(Number('{{ old('work_group_id', '0') }}')).trigger('change');
                }
            });

            selectWorkGroupId.change(function () {
                if (selectWorkGroupId.val()) {
                    let newOption;

                    selectWorkProgramId.attr('disabled');

                    axios.post('{{ route('api.work-programs') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        work_group_id: selectWorkGroupId.val(),
                    })
                        .then(function (response) {
                            selectWorkProgramId.empty();

                            let selectWorkProgramIdVal = "{{ old('cadre_activity_id', '') }}";

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkProgramId.append(newOption);
                            });

                            selectWorkProgramId.removeAttr('disabled');

                            if (selectWorkProgramIdVal) {
                                selectWorkProgramId.val(selectWorkProgramIdVal).trigger('change');
                            }
                        })
                }
            });

            selectWorkProgramId.change(function () {
                if (selectWorkProgramId.val()) {
                    let newOption;

                    selectCadreActivityId.attr('disabled');

                    axios.post('{{ route('api.cadre-activities') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        work_program: selectWorkProgramId.val(),
                    })
                        .then(function (response) {
                            selectCadreActivityId.empty();

                            let cadreActivityIdVal = Number("{{ old('cadre_activity_id', '') }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectCadreActivityId.append(newOption);
                            });

                            selectCadreActivityId.removeAttr('disabled');

                            if (cadreActivityIdVal) {
                                selectCadreActivityId.val(('{{ old('cadre_activity_id', '') }}')).trigger('change');
                            }
                        })
                }
            });

            selectCadreActivityId.change(function () {
                if (selectCadreActivityId.val()) {

                    axios.post('{{ route('api.studies') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        cadre_activity: selectCadreActivityId.val(),
                    })
                        .then(function (response) {
                            app.studies = response.data;
                        })

                    axios.post('{{ route('api.cadre-activities.data') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        cadre_activity: selectCadreActivityId.val(),
                    })
                        .then(function (response) {
                            app.cadreActivities = response.data;
                        })
                }
            });

            selectWorkProgramId.val(('{{ old('work_program_id', '') }}')).trigger('change');
        });
    </script>
@endsection
