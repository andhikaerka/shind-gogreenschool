@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.cadreActivity.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.cadre-activities.store", ['school_slug' => $school_slug]) }}"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.cadreActivity.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#date" autocomplete="off"
                           name="date" id="date" value="{{ old('date') }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.cadreActivity.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            required {{ !(auth()->user()->isSTC ?? false) ? 'disabled' : '' }}>
                        <option value="" disabled {{ old('work_group_id', '') == '' ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        @foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ old('work_group_id', '') == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_program_id">{{ trans('crud.cadreActivity.fields.work_program') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_program') ? 'is-invalid' : '' }}"
                            name="work_program_id" id="work_program_id" disabled="disabled"
                            required {{ !(auth()->user()->isSTC ?? false) ? 'disabled' : '' }}>
                        <option value="" disabled {{ old('work_program_id', '') == '' ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        {{--@foreach($workPrograms as $id => $workProgram)
                            <option
                                value="{{ $id }}" {{ old('work_program_id') == $id ? 'selected' : '' }}>{{ $workProgram }}</option>
                        @endforeach--}}
                    </select>
                    @if($errors->has('work_program'))
                        <span class="text-danger">{{ $errors->first('work_program') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.work_program_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="self_development">{{ trans('crud.study.fields.self_development') }}</label>
                    <select class="form-control select2-tags {{ $errors->has('self_development') ? 'is-invalid' : '' }}" name="self_development"
                            id="self_development" required>
                        <option value
                                disabled {{ old('self_development', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Study::LIST_OF_SELF_DEVELOPMENT as $label)
                            <option
                                value="{{ $label }}" {{ old('self_development') === (string) $label ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('self_development'))
                        <span class="text-danger">{{ $errors->first('self_development') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.self_development_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="condition">{{ trans('crud.cadreActivity.fields.condition') }}</label>
                    <select class="form-control {{ $errors->has('condition') ? 'is-invalid' : '' }}"
                            name="condition" id="condition"
                            required {{ !(auth()->user()->isSTC ?? false) ? 'disabled' : '' }}>
                        <option value="" disabled {{ old('condition', '') == '' ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        @foreach(\App\CadreActivity::CONDITION_SELECT as $id => $str)
                            <option
                                value="{{ $id }}" {{ old('condition', '') == $id ? 'selected' : '' }}>{{ $str }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('condition'))
                        <span class="text-danger">{{ $errors->first('condition') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.condition_helper') }}</span>
                </div>
                {{--<div class="form-group">
                    <label class="required" for="percentage">{{ trans('crud.cadreActivity.fields.percentage') }}</label>
                    <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number"
                           name="percentage"
                           id="percentage" value="{{ old('percentage', '') }}" step="1"
                           min="{{ \App\CadreActivity::MIN_PERCENTAGE }}"
                           max="{{ $maxPercentage }}" {{ app()->environment() == 'production' ? 'required' : '' }}>
                    @if($errors->has('percentage'))
                        <span class="text-danger">{{ $errors->first('percentage') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.percentage_helper') }}</span>
                </div>--}}
                <div class="form-group">
                    <label class="required" for="results">{{ trans('crud.cadreActivity.fields.results') }}</label>
                    <textarea class="form-control {{ $errors->has('results') ? 'is-invalid' : '' }}" name="results"
                              id="results" maxlength="{{ \App\CadreActivity::MAX_LENGTH_OF_RESULTS }}" required>{{ old('results') }}</textarea>
                    @if($errors->has('results'))
                        <span class="text-danger">{{ $errors->first('results') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.results_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="problem">{{ trans('crud.cadreActivity.fields.problem') }}</label>
                    <textarea class="form-control {{ $errors->has('problem') ? 'is-invalid' : '' }}" name="problem"
                              id="problem" maxlength="{{ \App\CadreActivity::MAX_LENGTH_OF_PROBLEM }}" required>{{ old('problem') }}</textarea>
                    @if($errors->has('problem'))
                        <span class="text-danger">{{ $errors->first('problem') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.problem_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="behavioral">{{ trans('crud.cadreActivity.fields.behavioral') }}</label>
                    <textarea class="form-control {{ $errors->has('behavioral') ? 'is-invalid' : '' }}"
                              name="behavioral" id="behavioral" maxlength="{{ \App\CadreActivity::MAX_LENGTH_OF_BEHAVIORAL }}" required>{{ old('behavioral') }}</textarea>
                    @if($errors->has('behavioral'))
                        <span class="text-danger">{{ $errors->first('behavioral') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.behavioral_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="physical">{{ trans('crud.cadreActivity.fields.physical') }}</label>
                    <textarea class="form-control {{ $errors->has('physical') ? 'is-invalid' : '' }}" name="physical"
                              id="physical" maxlength="{{ \App\CadreActivity::MAX_LENGTH_OF_PHYSICAL }}" required>{{ old('physical') }}</textarea>
                    @if($errors->has('physical'))
                        <span class="text-danger">{{ $errors->first('physical') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.physical_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="plan">{{ trans('crud.cadreActivity.fields.plan') }}</label>
                    <textarea class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" name="plan"
                              id="plan" maxlength="{{ \App\CadreActivity::MAX_LENGTH_OF_PLAN }}" required>{{ old('plan') }}</textarea>
                    @if($errors->has('plan'))
                        <span class="text-danger">{{ $errors->first('plan') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.plan_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="team_statuses">{{ trans('crud.cadreActivity.fields.team_statuses') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('team_statuses') ? 'is-invalid' : '' }}"
                            name="team_statuses[]" id="team_statuses" multiple required>
                        @foreach($teamStatuses as $id => $calendar)
                            <option
                                value="{{ $id }}" {{ in_array($id, old('team_statuses', [])) ? 'selected' : '' }}>{{ $calendar }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team_statuses'))
                        <span class="text-danger">{{ $errors->first('team_statuses') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.team_statuses_helper') }}</span>
                </div>

                <div class="form-group" v-if="workProgram">
                    <label class="required" for="date">{{ trans('crud.workProgram.fields.tutor') }}</label>
                    <div class="form-control-plaintext">
                        <ol>
                            <li v-if="workProgram.tutor_1">@{{ workProgram.tutor_1 }}</li>
                            <li v-if="workProgram.tutor_2">@{{ workProgram.tutor_2 }}</li>
                            <li v-if="workProgram.tutor_3">@{{ workProgram.tutor_3 }}</li>
                        </ol>
                    </div>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="document">{{ trans('crud.cadreActivity.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.document_helper') }}</span>
                </div>

                <div class="form-group">
                    <input type="hidden" name="add_more" id="add_more" value="{{ old('add_more', 0) }}">
                    <button class="btn btn-warning" type="button" onclick="$('#add_more').val(1); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.add') }} {{ trans('crud.cadreActivity.title_singular') }}?
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
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        $ = jQuery;

        const formCreate = $('form#formCreate');

        const app = new Vue({
            el: '#app',
            data: {
                workProgram: null,
            },
            mounted: function () {

            },
            methods: {}
        })

        $(function () {
            const selectWorkGroupId = $('select#work_group_id');
            const selectWorkProgramId = $('select#work_program_id');
            axios.post('{{ route('api.work-groups') }}', {
                school: '{{ auth()->user()->isSTC }}',
                year: {{ request()->get('year', date('Y')) }}
            })
            .then(function (response) {
                selectWorkGroupId.empty();

                let selectWorkGroupIdVal = "{!! old('work_program_id', '') !!}";

                response.data.forEach(function (data) {
                    newOption = new Option(data.text, data.id);
                    if (data.id === '') {
                        newOption.setAttribute('selected', 'selected');
                        newOption.setAttribute('disabled', 'disabled');
                    }
                    selectWorkGroupId.append(newOption);
                });

                selectWorkGroupId.removeAttr('disabled');

                if (selectWorkGroupIdVal) {
                    selectWorkGroupId.val(selectWorkGroupId).trigger('change');
                }
            })
            selectWorkGroupId.change(function () {
                if (selectWorkGroupId.val()) {
                    let newOption;

                    selectWorkProgramId.attr('disabled');

                    axios.post('{{ route('api.work-programs') }}', {
                        work_group: selectWorkGroupId.val(),
                    })
                        .then(function (response) {
                            selectWorkProgramId.empty();

                            let workProgramIdVal = Number("{{ old('work_program_id', '') }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkProgramId.append(newOption);
                            });

                            selectWorkProgramId.removeAttr('disabled');

                            if (workProgramIdVal) {
                                selectWorkProgramId.val(('{{ old('work_program_id', '') }}')).trigger('change');
                            }
                        })
                }
            });

            selectWorkGroupId.val(('{{ old('work_group_id', '') }}')).trigger('change');

            selectWorkProgramId.change(function () {
                if (selectWorkProgramId.val()) {
                    axios.post('{{ route('api.work-program') }}', {
                        work_program: selectWorkProgramId.val(),
                    })
                        .then(function (response) {
                            app.workProgram = response.data;
                        })
                }
            });
        });

        Dropzone.options.documentDropzone = {
            url: '{{ route('school.cadre-activities.storeMedia', ['school_slug' => $school_slug]) }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.pdf',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function (file, response) {
                const formCreate = $('form#formCreate');

                formCreate.find('input[name="document"]').remove();
                formCreate.append('<input type="hidden" name="document" value="' + response.name + '">')
            },
            removedfile: function (file) {
                const formCreate = $('form#formCreate');

                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="document"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                const formCreate = $('form#formCreate');

                    @if(isset($cadreActivity) && $cadreActivity->document)
                let file = {!! json_encode($cadreActivity->document) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="document" value="' + file.file_name + '">');
                this.options.maxFiles = this.options.maxFiles - 1;
                @endif
            },
            error: function (file, response) {
                let message;

                if ($.type(response) === 'string') {
                    message = response //dropzone sends it's own error messages in string
                } else {
                    message = response.errors.file
                }
                file.previewElement.classList.add('dz-error');
                let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
                let _results = [];
                for (let _i = 0, _len = _ref.length; _i < _len; _i++) {
                    let node = _ref[_i];
                    _results.push(node.textContent = message)
                }

                return _results
            }
        };
    </script>
@endsection
