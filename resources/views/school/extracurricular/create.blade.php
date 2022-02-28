@extends('layouts.school')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.extracurricular.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.extracurriculars.store", ['school_slug' => $school_slug]) }}"
                  enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <input type="hidden" name="year" value="{{ request()->input('year') }}" readonly>

                <div class="form-group">
                    <label class="required" for="program">{{ trans('crud.extracurricular.fields.program') }}</label>
                    <input class="form-control {{ $errors->has('program') ? 'is-invalid' : '' }}" type="text"
                           maxlength="{{ \App\Extracurricular::MAX_LENGTH_OF_PROGRAM }}" name="program"
                           id="program" value="{{ old('program', '') }}" required>
                    @if($errors->has('program'))
                        <span class="text-danger">{{ $errors->first('program') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.program_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="tutor">{{ trans('crud.extracurricular.fields.tutor') }}</label>
                    <select class="form-control select2 {{ $errors->has('tutor') ? 'is-invalid' : '' }}"
                            name="tutor" id="tutor"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('tutor'))
                        <span class="text-danger">{{ $errors->first('tutor') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.tutor_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="time">{{ trans('crud.extracurricular.fields.time') }}</label>
                    <input class="form-control time {{ $errors->has('time') ? 'is-invalid' : '' }}"  type="text"
                        maxlength="{{ \App\Extracurricular::MAX_LENGTH_OF_TIME }}"
                        name="time" id="time" value="{{ old('time') }}" required>
                    @if($errors->has('time'))
                        <span class="text-danger">{{ $errors->first('time') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.time_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="participants">{{ trans('crud.extracurricular.fields.participants') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('participants') ? 'is-invalid' : '' }}"
                            name="participants[]" id="participants"
                            multiple {{ app()->environment() == 'production' ? 'required' : '' }}>
                        @foreach($teamStatuses as $id => $team_status)
                            <option
                                value="{{ $id }}" {{ in_array($id, old('participants', [])) ? 'selected' : '' }}>{{ $team_status }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('participants'))
                        <span class="text-danger">{{ $errors->first('participants') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.participants_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="activity">{{ trans('crud.extracurricular.fields.activity') }}</label>
                    <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity"
                              id="activity" maxlength="{{ \App\Extracurricular::MAX_LENGTH_OF_ACTIVITY }}"
                              required>{{ old('activity') }}</textarea>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.activity_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="target">{{ trans('crud.extracurricular.fields.target') }}</label>
                    <textarea class="form-control {{ $errors->has('target') ? 'is-invalid' : '' }}" name="target"
                              id="target" maxlength="{{ \App\Extracurricular::MAX_LENGTH_OF_TARGET }}" required>{{ old('target') }}</textarea>
                    @if($errors->has('target'))
                        <span class="text-danger">{{ $errors->first('target') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.target_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="letter">{{ trans('crud.extracurricular.fields.letter') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('letter') ? 'is-invalid' : '' }}"
                         id="letter-dropzone">
                    </div>
                    @if($errors->has('letter'))
                        <span class="text-danger">{{ $errors->first('letter') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.letter_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="document">{{ trans('crud.extracurricular.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.document_helper') }}</span>
                </div>

                <div class="form-group">
                    <input type="hidden" name="add_more" id="add_more" value="{{ old('add_more', 0) }}">
                    <button class="btn btn-warning" type="button" onclick="$('#add_more').val(1); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.add') }} {{ trans('crud.cadre.title_singular') }}?
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

        const formCreate = $('form#formCreate');

        Dropzone.options.documentDropzone = {
            url: '{{ route('school.extracurriculars.storeMedia', ['school_slug' => $school_slug]) }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.pdf, .jpg',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function (file, response) {
                formCreate.find('input[name="document"]').remove();
                formCreate.append('<input type="hidden" name="document" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="document"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($extracurricular) && $extracurricular->document)
                let file = {!! json_encode($extracurricular->document) !!}
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
        }

        Dropzone.options.letterDropzone = {
            url: '{{ route('school.extracurriculars.storeMedia', ['school_slug' => $school_slug]) }}',
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
                formCreate.find('input[name="letter"]').remove();
                formCreate.append('<input type="hidden" name="letter" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="letter"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($extracurricular) && $extracurricular->letter)
                let file = {!! json_encode($extracurricular->letter) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="letter" value="' + file.file_name + '">');
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

        $(function () {
            const selectedCompiler = $('#tutor');

            axios.post('{{ route('api.teams') }}', {
                type: 'pembimbing',
                school_id: '{{ auth()->user()->isSTC }}'
            })
                .then(function (response) {
                    let selectedCompilerVal = "{!! old('tutor', '') !!}";
                    selectedCompiler.empty();
                    response.data.forEach(function (data) {
                        newOption = new Option(data.text, data.text);
                        if (data.id === '') {
                            newOption.setAttribute('selected', 'selected');
                            newOption.setAttribute('disabled', 'disabled');
                        }
                        selectedCompiler.append(newOption);
                    });

                    selectedCompiler.removeAttr('disabled');

                    if(selectedCompilerVal){
                        selectedCompiler.val(selectedCompilerVal).trigger('change');
                        console.log(1)
                    }
                        console.log(2)
                })
        });
    </script>
@endsection
