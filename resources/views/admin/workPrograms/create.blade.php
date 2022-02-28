@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.workProgram.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.work-programs.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.workGroup.fields.school') }}</label>
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
                    <span class="help-block">{{ trans('crud.workGroup.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.workProgram.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id" required>
                        <option value
                                disabled {{ old('work_group_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="study_id">{{ trans('crud.workProgram.fields.study') }}</label>
                    <select class="form-control select2 {{ $errors->has('study') ? 'is-invalid' : '' }}" name="study_id"
                            id="study_id" required disabled>
                        <option value
                                disabled {{ old('study_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if($errors->has('study'))
                        <span class="text-danger">{{ $errors->first('study') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.study_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="condition">{{ trans('crud.workProgram.fields.condition') }}</label>
                    <textarea class="form-control {{ $errors->has('condition') ? 'is-invalid' : '' }}" name="condition"
                              id="condition" required>{{ old('condition') }}</textarea>
                    @if($errors->has('condition'))
                        <span class="text-danger">{{ $errors->first('condition') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.condition_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="plan">{{ trans('crud.workProgram.fields.plan') }}</label>
                    <textarea class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" name="plan" id="plan"
                              required>{{ old('plan') }}</textarea>
                    @if($errors->has('plan'))
                        <span class="text-danger">{{ $errors->first('plan') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.plan_helper') }}</span>
                </div>

                {{--<div class="form-group" v-show="cts.length">
                    <label class="required" for="activity">{{ trans('crud.study.fields.activity') }}</label>
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
                                               :checked="checklist_templates.includes(String(checklistTemplate.id))"
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
                                                       :checked="checklist_templates.includes(String(checklistTemplate.id))">
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
                                       :checked="checklist_templates.includes(String(ct.id))">
                                <label class="form-check-label" for="'inlineCheckbox'+ct.id">
                                    @{{ ct.text }}
                                </label>
                            </div>
                        </li>

                        <li>
                            <span class="help-block">Upaya lain ketik disini ...</span>
                            <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}"
                                      name="activity"
                                      id="activity" {{ app()->environment() == 'production' ? 'required' : '' }}>{{ old('activity') }}</textarea>
                            @if($errors->has('activity'))
                                <span class="text-danger">{{ $errors->first('activity') }}</span>
                            @endif
                            <span class="help-block">{{ trans('crud.study.fields.activity_helper') }}</span>
                        </li>
                    </ol>
                </div>--}}

                <div class="form-group">
                    <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1"
                               required {{ old('featured', 0) == 1 ? 'checked' : '' }}>
                        <label class="required form-check-label"
                               for="featured">{{ trans('crud.workProgram.fields.featured') }}</label>
                    </div>
                    @if($errors->has('featured'))
                        <span class="text-danger">{{ $errors->first('featured') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.featured_helper') }}</span>
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
        const formCreate = $('form#formCreate');

        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.work-programs.storeMedia') }}',
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
                formCreate.find('input[name="photo"]').remove();
                formCreate.append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="photo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($workProgram) && $workProgram->photo)
                let file = {!! json_encode($workProgram->photo) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="photo" value="' + file.file_name + '">');
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

    <script>
        $(function () {
            const selectSchoolId = $('select#school_id');
            const selectWorkGroupId = $('select#work_group_id');
            const selectStudyId = $('select#study_id');

            selectSchoolId.change(function () {
                if (selectSchoolId.val()) {
                    let newOption;

                    selectWorkGroupId.attr('disabled');

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

                            selectWorkGroupId.val(workGroupIdVal).trigger('change');
                        })
                }
            });

            selectWorkGroupId.change(function () {
                if (selectWorkGroupId.val()) {
                    let newOption;

                    selectStudyId.attr('disabled');

                    axios.post('{{ route('api.studies') }}', {
                        work_group: selectWorkGroupId.val(),
                    })
                        .then(function (response) {
                            selectStudyId.empty();

                            let studyIdVal = Number("{{ old('study_id', '') }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === studyIdVal), (data.id === studyIdVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectStudyId.append(newOption);
                            });

                            selectStudyId.removeAttr('disabled');
                        })
                }
            });

            selectSchoolId.val(("{{ old('school_id', null) }}")).trigger('change');
        });
    </script>
@endsection
