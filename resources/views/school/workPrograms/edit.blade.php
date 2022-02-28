@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.workProgram.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.work-programs.update", ['school_slug' => $school_slug, $workProgram->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label class="required"
                           for="aspect_id">{{ trans('crud.workProgram.fields.aspect') }}</label>
                    <select class="form-control select2 {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        <option value="0" disabled>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($aspects as $id => $aspect)
                            <option value="{{ $id }}">{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect_id'))
                        <span class="text-danger">{{ $errors->first('aspect_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.aspect_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.workProgram.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group_id') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            {{ app()->environment() == 'production' ? 'required' : '' }} disabled="disabled">
                        <option value disabled>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        {{--@foreach($workGroups as $id => $workGroup)
                            <option value="{{ $id }}">{{ $workGroup }}</option>
                        @endforeach--}}
                    </select>
                    @if($errors->has('work_group_id'))
                        <span class="text-danger">{{ $errors->first('work_group_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.work_group_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="name">{{ trans('crud.workProgram.fields.name') }}</label>
                    <select class="form-control select2 {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            name="name" id="name"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="study_id">{{ trans('crud.workProgram.fields.study') }}</label>
                    <select class="form-control select2 {{ $errors->has('study') ? 'is-invalid' : '' }}" name="study_id"
                            id="study_id" required disabled>
                        <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if($errors->has('study'))
                        <span class="text-danger">{{ $errors->first('study') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.study_helper') }}</span>
                </div>

                <div class="form-group" v-if="study.potential">
                    <label class="required" for="potential">{{ trans('crud.study.fields.potential') }}</label>
                    <div id="potential" class="form-control-plaintext">@{{ study.potential }}</div>
                </div>
                <div class="form-group" v-if="study.problem">
                    <label class="required" for="problem">{{ trans('crud.study.fields.problem') }}</label>
                    <div id="problem" class="form-control-plaintext">@{{ study.problem }}</div>
                </div>

                <div class="form-group" v-if="study.behavioral">
                    <label class="required" for="behavioral">{{ trans('crud.study.fields.behavioral') }}</label>
                    <div id="behavioral" class="form-control-plaintext">@{{ study.behavioral }}</div>
                </div>
                <div class="form-group" v-if="study.physical">
                    <label class="required" for="physical">{{ trans('crud.study.fields.physical') }}</label>
                    <div id="physical" class="form-control-plaintext">@{{ study.physical }}</div>
                </div>
                <div class="form-group" v-if="study.period">
                    <label class="required" for="period">{{ trans('crud.study.fields.period') }}</label>
                    <div id="period" class="form-control-plaintext">@{{ study.period }} Bulan</div>
                </div>

                <div class="form-group">
                    <label class="required" for="condition">{{ trans('crud.workProgram.fields.condition') }}</label>
                    <textarea class="form-control {{ $errors->has('condition') ? 'is-invalid' : '' }}" name="condition"
                              id="condition" maxlength="{{ \App\WorkProgram::MAX_LENGTH_OF_CONDITION }}"
                              required>{{ old('condition', $workProgram->condition) }}</textarea>
                    @if($errors->has('condition'))
                        <span class="text-danger">{{ $errors->first('condition') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.condition_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="plan">{{ trans('crud.workProgram.fields.plan') }}</label>
                    <textarea class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" name="plan" id="plan"
                              maxlength="{{ \App\WorkProgram::MAX_LENGTH_OF_PLAN }}"
                              required>{{ old('plan', $workProgram->plan) }}</textarea>
                    @if($errors->has('plan'))
                        <span class="text-danger">{{ $errors->first('plan') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.plan_helper') }}</span>
                </div>

                {{--<div class="form-group" v-show="cts.length">
                    <label class="required" for="activity">{{ trans('crud.workProgram.fields.activity') }}</label>
                    <ol type="1">
                        <li v-for="(ct, ctIndex) in cts">
                            <div v-if="ct.isParent === true">
                                <div>@{{ ct.name }}</div>
                                <div v-if="ct.selectAll === 1">
                                    <div v-for="(checklistTemplate, checklistTemplateIndex) in ct.checklistTemplates"
                                         class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                               :id="'inlineCheckbox'+checklistTemplate.id"
                                               :value="checklistTemplate.id" name="checklist_templates[]"
                                               :checked="checklist_templates.includes(String(checklistTemplate.id)) || checklist_templates.includes((checklistTemplate.id))"
                                        >
                                        <label class="form-check-label" :for="'inlineCheckbox'+checklistTemplate.id">
                                            @{{ checklistTemplate.text }}
                                        </label>
                                    </div>
                                </div>
                                <div v-else>
                                    <ol type="i">
                                        <li v-for="(checklistTemplate, checklistTemplateIndex) in ct.checklistTemplates">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       :id="'inlineCheckbox'+checklistTemplate.id"
                                                       :value="checklistTemplate.id" name="checklist_templates[]"
                                                       :checked="checklist_templates.includes(String(checklistTemplate.id)) || checklist_templates.includes((checklistTemplate.id))">
                                                <label class="form-check-label"
                                                       :for="'inlineCheckbox'+checklistTemplate.id">
                                                    @{{ checklistTemplate.text }}
                                                </label>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            <div v-else class="form-check">
                                <input class="form-check-input" type="checkbox" :value="ct.id"
                                       :id="'inlineCheckbox'+ct.id" name="checklist_templates[]"
                                       :checked="checklist_templates.includes(String(ct.id)) || checklist_templates.includes((ct.id))">
                                <label class="form-check-label" for="'inlineCheckbox'+ct.id">
                                    @{{ ct.text }}
                                </label>
                            </div>
                        </li>

                        <li>
                            <span class="help-block">Upaya lain ketik disini ...</span>
                            <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}"
                                      name="activity"
                                      id="activity" {{ app()->environment() == 'production' ? 'required' : '' }}>{{ old('activity', $workProgram->activity) }}</textarea>
                            @if($errors->has('activity'))
                                <span class="text-danger">{{ $errors->first('activity') }}</span>
                            @endif
                            <span class="help-block">{{ trans('crud.workProgram.fields.activity_helper') }}</span>
                        </li>
                    </ol>
                </div>--}}

                <div class="form-group">
                    <label class="required" for="time">{{ trans('crud.workProgram.fields.time') }}</label>
                    <select class="form-control {{ $errors->has('time') ? 'is-invalid' : '' }}" name="time"
                            id="time" required>
                        <option value
                                disabled {{ old('time', $workProgram->time) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @for($i = \App\WorkProgram::MIN_TIME; $i <= \App\WorkProgram::MAX_TIME; $i++)
                            <option
                                value="{{ $i }}" {{ old('time', $workProgram->time) == $i ? 'selected' : '' }}>{{ $i }} Bulan
                            </option>
                        @endfor
                    </select>
                    @if($errors->has('time'))
                        <span class="text-danger">{{ $errors->first('time') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.time_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="percentage">{{ trans('crud.workProgram.fields.percentage') }}</label>
                    <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number"
                           name="percentage"
                           id="percentage" value="{{ old('percentage', $workProgram->percentage) }}" step="1"
                           min="{{ \App\Study::MIN_PERCENTAGE }}"
                           max="0" {{ app()->environment() == 'production' ? 'required' : '' }}>
                    <span id="percentage-status" class="help-block text-danger"></span>
                    <span class="help-block">{{ trans('crud.workProgram.fields.percentage_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="tutor_1">{{ trans('crud.workProgram.fields.tutor_1') }}</label>
                    {{-- <select class="form-control select2 {{ $errors->has('tutor_1') ? 'is-invalid' : '' }}"
                            name="tutor_1" id="tutor_1"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        @foreach($tutors_1 as $id => $tutor_1)
                            <option value="{{ $id }}" {{ old('tutor_1', $workProgram->tutor_1) == $id ? 'selected' : '' }}>{{ $tutor_1 }}</option>
                        @endforeach
                    </select> --}}
                    <input type="text" name="tutor_1" id="tutor_1" class="form-control {{ $errors->has('tutor_1') ? 'is-invalid' : '' }}" readonly>
                    @if($errors->has('tutor_1'))
                        <span class="text-danger">{{ $errors->first('tutor_1') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.tutor_1_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="tutor_2">{{ trans('crud.workProgram.fields.tutor_2') }}</label>
                    <select class="form-control select2 {{ $errors->has('tutor_2') ? 'is-invalid' : '' }}"
                            name="tutor_2" id="tutor_2"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        @foreach($tutors_2 as $id => $tutor_2)
                            <option value="{{ $id }}" {{ old('tutor_2', $workProgram->tutor_2) == $id ? 'selected' : '' }}>{{ $tutor_2 }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('tutor_2'))
                        <span class="text-danger">{{ $errors->first('tutor_2') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.tutor_2_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="tutor_3">{{ trans('crud.workProgram.fields.tutor_3') }}</label>
                    <select class="form-control select2 {{ $errors->has('tutor_3') ? 'is-invalid' : '' }}"
                        name="tutor_3" id="tutor_3"
                    {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('tutor_3'))
                        <span class="text-danger">{{ $errors->first('tutor_3') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.tutor_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="photo">{{ trans('crud.workProgram.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                         id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.photo_helper') }}</span>
                </div>


                <div class="form-group">
                    <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1"
                               {{ $workProgram->featured || old('featured', 0) === 1 ? 'checked' : '' }}>
                        <label class="required form-check-label"
                               for="featured">{{ trans('crud.workProgram.fields.featured') }}</label>
                    </div>
                    @if($errors->has('featured'))
                        <span class="text-danger">{{ $errors->first('featured') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.featured_helper') }}</span>
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
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                study: [],
                cts: [],
            },
            mounted: function () {

            },
            methods: {}
        })

        $ = jQuery;

        $(function () {
            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');
            const selectStudyId = $('select#study_id');
            const tutor1 = $('#tutor_1');
            const tutor3 = $('#tutor_3');
            const name = $('#name');
            const percentage = $('#percentage');
            const percentageStatus = $('#percentage-status');

            let newOption;

            selectAspectId.change(function () {
                axios.post('{{ route('api.work-groups') }}', {
                    school: '{{ auth()->user()->isSTC }}',
                    aspect: selectAspectId.val(),
                })
                    .then(function (response) {
                        selectWorkGroupId.empty();

                        let workGroupIdVal = Number("{{ old('work_group_id', ($workProgram->study->work_group_id ?? '')) }}");

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
                            selectWorkGroupId.val(Number('{{ old('work_group_id', ($workProgram->study->work_group_id ?? '')) }}')).trigger('change');
                        }
                    });

                /*axios.post('{{ route('api.checklist-templates') }}', {
                    aspect: selectAspectId.val(),
                })
                    .then(function (response) {
                        app.cts = response.data;
                    })*/
            });

            selectAspectId.val(Number('{{ old('aspect_id', ($workProgram->study->work_group->aspect_id ?? '')) }}')).trigger('change');

            selectWorkGroupId.change(function () {
                if (selectWorkGroupId.val()) {
                    let newOption;

                    selectStudyId.attr('disabled');
                    let tutor1Name = $(this).find(':selected').text().split('Guru Pembimbing: ')[1];
                    tutor1.val(tutor1Name)

                    axios.post('{{ route('api.studies') }}', {
                        work_group: selectWorkGroupId.val(),
                    })
                        .then(function (response) {
                            selectStudyId.empty();

                            let studyIdVal = Number("{{ old('study_id', $workProgram->study_id) }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectStudyId.append(newOption);
                            });

                            selectStudyId.removeAttr('disabled');

                            if (studyIdVal) {
                                selectStudyId.val(Number('{{ old('study_id', $workProgram->study_id) }}')).trigger('change');
                            }
                        })

                    axios.post('{{ route('api.teams') }}', {
                        type: 'pembimbing',
                        work_group_id: selectWorkGroupId.val(),
                        school_id: '{{ auth()->user()->isSTC }}'
                    })
                        .then(function (response) {
                            tutor3.empty();
                            let tutor3Val = '{{ old('tutor_3', ($workProgram->tutor_3 ?? '')) }}';
                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.text);
                                if(data.text == tutor3Val) {
                                    newOption.setAttribute('selected', 'selected');
                                }
                                else if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                tutor3.append(newOption);
                            });

                            tutor3.removeAttr('disabled');
                        })

                    axios.post('{{ route('api.checklist-templates-by-group') }}', {
                        school_slug: '{{ $school_slug }}',
                        work_group_id: selectWorkGroupId.val()
                    })
                        .then(function (response) {
                            name.empty();
                            let nameVal = "{!! old('name', $workProgram->name) !!}";
                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.text);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                name.append(newOption);
                            });

                            name.removeAttr('disabled');

                            if (nameVal) {
                                name.val(nameVal).trigger('change');
                            }
                        })

                    axios.post('{{ route('api.work-programs.get-percentage') }}', {
                        school_slug: '{{ $school_slug }}',
                        work_group_id: selectWorkGroupId.val()
                    })
                    .then(function (response) {
                        let old = {!! $workProgram->percentage !!};
                        percentage.attr('max', (response.data.maxPercentage + old))
                        percentageStatus.text('Sudah terpakai '+(100-old-response.data.maxPercentage)+'% dan sisa '+(response.data.maxPercentage+old)+'%')
                        percentage.prop( "disabled", false );
                    });
                }
            });

            selectStudyId.change(function () {
                if (selectStudyId.val()) {
                    axios.post('{{ route('api.study') }}', {
                        study: selectStudyId.val(),
                    })
                        .then(function (response) {
                            app.study = response.data.study;
                            app.cts = response.data;
                        })
                }
            });
        });

        Dropzone.options.photoDropzone = {
            url: '{{ route('school.work-programs.storeMedia', ['school_slug' => $school_slug]) }}',
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
                $('form#formEdit').find('input[name="photo"]').remove();
                $('form#formEdit').append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form#formEdit').find('input[name="photo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($workProgram) && $workProgram->photo)
                let file = {!! json_encode($workProgram->photo) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                $('form#formEdit').append('<input type="hidden" name="photo" value="' + file.file_name + '">');
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
        }
    </script>
@endsection
