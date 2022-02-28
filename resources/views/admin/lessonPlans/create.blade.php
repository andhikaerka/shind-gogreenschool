@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.lessonPlan.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.lesson-plans.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.lessonPlan.fields.school') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}"
                            name="school_id" id="school_id" required @change="selectOnChange">
                        @foreach($schools as $id => $school)
                            <option
                                value="{{ $id }}" {{ old('school_id') == $id ? 'selected' : '' }}>{{ $school }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('school'))
                        <span class="text-danger">{{ $errors->first('school') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="ktsp_or_rpp">{{ trans('crud.lessonPlan.fields.ktsp_or_rpp') }}</label>
                    <select class="form-control {{ $errors->has('ktsp_or_rpp') ? 'is-invalid' : '' }}"
                            name="ktsp_or_rpp" id="ktsp_or_rpp" v-model="ktsp_or_rpp" @change="selectOnChange" required>
                        <option value
                                disabled {{ old('ktsp_or_rpp', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\LessonPlan::KTSP_OR_RPP_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('ktsp_or_rpp', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('ktsp_or_rpp'))
                        <span class="text-danger">{{ $errors->first('ktsp_or_rpp') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.ktsp_or_rpp_helper') }}</span>
                </div>

                <div v-if="ktsp_or_rpp === 'KTSP'">
                    <div class="form-group">
                        <label class="required" for="vision">{{ trans('crud.lessonPlan.fields.vision') }}</label>
                        <textarea class="form-control {{ $errors->has('vision') ? 'is-invalid' : '' }}" name="vision"
                                  id="vision" required>{{ old('vision') }}</textarea>
                        @if($errors->has('vision'))
                            <span class="text-danger">{{ $errors->first('vision') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.vision_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="mission">{{ trans('crud.lessonPlan.fields.mission') }}</label>
                        <textarea class="form-control {{ $errors->has('mission') ? 'is-invalid' : '' }}" name="mission"
                                  id="mission" required>{{ old('mission') }}</textarea>
                        @if($errors->has('mission'))
                            <span class="text-danger">{{ $errors->first('mission') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.mission_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="purpose">{{ trans('crud.lessonPlan.fields.purpose') }}</label>
                        <textarea class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose"
                                  id="purpose" required>{{ old('purpose') }}</textarea>
                        @if($errors->has('purpose'))
                            <span class="text-danger">{{ $errors->first('purpose') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.purpose_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="calendars">{{ trans('crud.lessonPlan.fields.calendars') }}</label>
                        <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all"
                                  style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('calendars') ? 'is-invalid' : '' }}"
                                name="calendars[]" id="calendars" multiple required>
                            @foreach($calendars as $id => $calendar)
                                <option
                                    value="{{ $id }}" {{ in_array($id, old('calendars', [])) ? 'selected' : '' }}>{{ $calendar }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('calendars'))
                            <span class="text-danger">{{ $errors->first('calendars') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.calendars_helper') }}</span>
                    </div>
                </div>

                <div v-if="ktsp_or_rpp === 'RPP'">
                    <div class="form-group">
                        <label class="required" for="subject">{{ trans('crud.lessonPlan.fields.subject') }}</label>
                        <input class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" type="text"
                               name="subject" id="subject" value="{{ old('subject', '') }}" required>
                        @if($errors->has('subject'))
                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.subject_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="teacher">{{ trans('crud.lessonPlan.fields.teacher') }}</label>
                        <input class="form-control {{ $errors->has('teacher') ? 'is-invalid' : '' }}" type="text"
                               name="teacher" id="teacher" value="{{ old('teacher', '') }}" required>
                        @if($errors->has('teacher'))
                            <span class="text-danger">{{ $errors->first('teacher') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.teacher_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="class">{{ trans('crud.lessonPlan.fields.class') }}</label>
                        <select class="form-control {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class"
                                id="class"
                                required disabled>
                            <option value disabled {{ old('class', null) === null ? 'selected' : '' }}>
                                {{ trans('global.pleaseSelect') }}
                            </option>
                        </select>
                        @if($errors->has('class'))
                            <span class="text-danger">{{ $errors->first('class') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.class_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="aspect_id">{{ trans('crud.lessonPlan.fields.aspect') }}</label>
                        <select class="form-control {{ $errors->has('aspect') ? 'is-invalid' : '' }}"
                                name="aspect_id" id="aspect_id" required @change="selectOnChange">
                            @foreach($aspects as $id => $aspect)
                                <option
                                    value="{{ $id }}" {{ old('aspect_id') == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('aspect'))
                            <span class="text-danger">{{ $errors->first('aspect') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.aspect_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="hook">{{ trans('crud.lessonPlan.fields.hook') }}</label>
                        <input class="form-control {{ $errors->has('hook') ? 'is-invalid' : '' }}" type="text" maxlength="191"
                               name="hook"
                               id="hook" value="{{ old('hook', '') }}" required>
                        @if($errors->has('hook'))
                            <span class="text-danger">{{ $errors->first('hook') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.hook_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="artwork">{{ trans('crud.lessonPlan.fields.artwork') }}</label>
                        <textarea class="form-control {{ $errors->has('artwork') ? 'is-invalid' : '' }}" name="artwork"
                                  id="artwork" required>{{ old('artwork') }}</textarea>
                        @if($errors->has('artwork'))
                            <span class="text-danger">{{ $errors->first('artwork') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.artwork_helper') }}</span>
                    </div>
                    <div class="form-group" id="divHour">
                        <label class="required" for="hour">{{ trans('crud.lessonPlan.fields.hour') }}</label>
                        <input class="form-control {{ $errors->has('hour') ? 'is-invalid' : '' }}" type="number"
                               name="hour"
                               id="hour" value="{{ old('hour', '') }}" step="1" min="1" required>
                        @if($errors->has('hour'))
                            <span class="text-danger">{{ $errors->first('hour') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.hour_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="period">{{ trans('crud.lessonPlan.fields.period') }}</label>
                        <select class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" name="period"
                                id="period" required>
                            <option value
                                    disabled {{ old('period', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\LessonPlan::PERIOD_SELECT as $key => $label)
                                <option
                                    value="{{ $key }}" {{ old('period', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('period'))
                            <span class="text-danger">{{ $errors->first('period') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.period_helper') }}</span>
                    </div>
                </div>
                <div v-show="ktsp_or_rpp === 'RPP'">
                    <div class="form-group">
                        <label class="required" for="syllabus">{{ trans('crud.lessonPlan.fields.syllabus') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('syllabus') ? 'is-invalid' : '' }}"
                             id="syllabus-dropzone">
                        </div>
                        @if($errors->has('syllabus'))
                            <span class="text-danger">{{ $errors->first('syllabus') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.syllabus_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="rpp">{{ trans('crud.lessonPlan.fields.rpp') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('rpp') ? 'is-invalid' : '' }}"
                             id="rpp-dropzone">
                        </div>
                        @if($errors->has('rpp'))
                            <span class="text-danger">{{ $errors->first('rpp') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.lessonPlan.fields.rpp_helper') }}</span>
                    </div>
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
        const formCreate = $('form#formCreate');

        Dropzone.options.syllabusDropzone = {
            url: '{{ route('admin.lesson-plans.storeMedia') }}',
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
                formCreate.find('input[name="syllabus"]').remove();
                formCreate.append('<input type="hidden" name="syllabus" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="syllabus"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($lessonPlan) && $lessonPlan->syllabus)
                let file = {!! json_encode($lessonPlan->syllabus) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="syllabus" value="' + file.file_name + '">');
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

        Dropzone.options.rppDropzone = {
            url: '{{ route('admin.lesson-plans.storeMedia') }}',
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
                formCreate.find('input[name="rpp"]').remove();
                formCreate.append('<input type="hidden" name="rpp" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="rpp"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($lessonPlan) && $lessonPlan->rpp)
                let file = {!! json_encode($lessonPlan->rpp) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="rpp" value="' + file.file_name + '">');
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
        const app = new Vue({
            el: '#app',
            data: {
                ktsp_or_rpp: '{{ old('ktsp_or_rpp', 'RPP') }}'
            },
            mounted: function () {
                this.selectOnChange();
            },
            methods: {
                selectOnChange() {
                    setTimeout(function () {
                        if (app.ktsp_or_rpp === 'KTSP') {
                            $('.select2').select2();

                            $('select#calendars').show();
                        }

                        if (app.ktsp_or_rpp === 'RPP') {
                            $('div#divHour .select2').hide();
                        }
                    }, 1000);
                }
            }
        })
    </script>
@endsection
