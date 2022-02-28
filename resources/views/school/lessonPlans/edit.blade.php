@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.lessonPlan.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.lesson-plans.update", ['school_slug' => $school_slug, $lessonPlan->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label class="required" for="subject">{{ trans('crud.lessonPlan.fields.subject') }}</label>
                    <input class="form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" type="text"
                           name="subject" id="subject" value="{{ old('subject', $lessonPlan->subject) }}"
                           maxlength="{{ \App\LessonPlan::MAX_LENGTH_OF_SUBJECT }}" required>
                    @if($errors->has('subject'))
                        <span class="text-danger">{{ $errors->first('subject') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.subject_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="teacher">{{ trans('crud.lessonPlan.fields.teacher') }}</label>
                    <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}"
                            name="teacher" id="teacher"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('teacher'))
                        <span class="text-danger">{{ $errors->first('teacher') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.teacher_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="class">{{ trans('crud.lessonPlan.fields.class') }}</label>
                    <select class="form-control {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class" id="class"
                            required>
                        <option value
                                disabled {{ old('class', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\LessonPlan::CLASS_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('class', $lessonPlan->class) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('class'))
                        <span class="text-danger">{{ $errors->first('class') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.class_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.infrastructure.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id" required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', $lessonPlan->aspect_id) == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect'))
                        <span class="text-danger">{{ $errors->first('aspect') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="hook">{{ trans('crud.lessonPlan.fields.hook') }}</label>
                    <input class="form-control {{ $errors->has('hook') ? 'is-invalid' : '' }}" type="text"
                           maxlength="{{ \App\LessonPlan::MAX_LENGTH_OF_HOOK }}" name="hook"
                           id="hook" value="{{ old('hook', $lessonPlan->hook) }}" required>
                    @if($errors->has('hook'))
                        <span class="text-danger">{{ $errors->first('hook') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.hook_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="cenvironmental_issue_id">{{ trans('crud.lessonPlan.fields.environmental_issue_id') }}</label>
                    <select class="form-control select2 {{ $errors->has('environmental_issue_id') ? 'is-invalid' : '' }}" name="environmental_issue_id"
                            id="environmental_issue_id" required>
                        <option value disabled {{ old('environmental_issue_id', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        @foreach($environmentalIssues as $key => $environmentalIssue)
                            <option
                                value="{{ $key }}" {{ old('environmental_issue_id', $lessonPlan->environmental_issue_id) === $key ? 'selected' : '' }}>
                                {{ $environmentalIssue }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('environmental_issue_id'))
                        <span class="text-danger">{{ $errors->first('environmental_issue_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.environmental_issue_id_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="artwork">{{ trans('crud.lessonPlan.fields.artwork') }}</label>
                    <textarea class="form-control {{ $errors->has('artwork') ? 'is-invalid' : '' }}" name="artwork"
                              id="artwork" maxlength="{{ \App\LessonPlan::MAX_LENGTH_OF_ARTWORK }}"
                              required>{{ old('artwork', $lessonPlan->artwork) }}</textarea>
                    @if($errors->has('artwork'))
                        <span class="text-danger">{{ $errors->first('artwork') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.artwork_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="hour">{{ trans('crud.lessonPlan.fields.hour') }}</label>
                    <input class="form-control {{ $errors->has('hour') ? 'is-invalid' : '' }}" type="number" min="1"
                           name="hour"
                           id="hour" value="{{ old('hour', $lessonPlan->hour) }}" step="1" required>
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
                                value="{{ $key }}" {{ old('period', $lessonPlan->period) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('period'))
                        <span class="text-danger">{{ $errors->first('period') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.period_helper') }}</span>
                </div>
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
                    <div class="needsclick dropzone {{ $errors->has('rpp') ? 'is-invalid' : '' }}" id="rpp-dropzone">
                    </div>
                    @if($errors->has('rpp'))
                        <span class="text-danger">{{ $errors->first('rpp') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.rpp_helper') }}</span>
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
        const formEdit = $('form#formEdit');

        Dropzone.options.syllabusDropzone = {
            url: '{{ route('school.lesson-plans.storeMedia', ['school_slug' => $school_slug]) }}',
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
                formEdit.find('input[name="syllabus"]').remove();
                formEdit.append('<input type="hidden" name="syllabus" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formEdit.find('input[name="syllabus"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($lessonPlan) && $lessonPlan->syllabus)
                let file = {!! json_encode($lessonPlan->syllabus) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formEdit.append('<input type="hidden" name="syllabus" value="' + file.file_name + '">');
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
            url: '{{ route('school.lesson-plans.storeMedia', ['school_slug' => $school_slug]) }}',
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
                formEdit.find('input[name="rpp"]').remove();
                formEdit.append('<input type="hidden" name="rpp" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formEdit.find('input[name="rpp"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($lessonPlan) && $lessonPlan->rpp)
                let file = {!! json_encode($lessonPlan->rpp) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formEdit.append('<input type="hidden" name="rpp" value="' + file.file_name + '">');
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

        const teacher = $('#teacher');

        axios.post('{{ route('api.teams') }}', {
            school_id: '{{ auth()->user()->isSTC }}'
        })
            .then(function (response) {
                teacher.empty();
                let teacherVal = "{!! old('teacher', $lessonPlan->teacher) !!}";
                response.data.forEach(function (data) {
                    newOption = new Option(data.text, data.text);
                    if (data.id === '') {
                        newOption.setAttribute('selected', 'selected');
                        newOption.setAttribute('disabled', 'disabled');
                    }
                    teacher.append(newOption);
                });

                teacher.removeAttr('disabled');

                if (teacherVal) {
                    teacher.val(teacherVal).trigger('change');
                }
            })
    </script>
@endsection
