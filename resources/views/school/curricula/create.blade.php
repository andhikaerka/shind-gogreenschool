@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.curriculum.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.curricula.store", ['school_slug' => $school_slug]) }}"
                  enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <input type="hidden" name="year" value="{{ request()->input('year') }}" readonly>

                <div class="form-group">
                    <label class="required" for="vision">{{ trans('crud.curriculum.fields.vision') }}</label>
                    <textarea class="form-control {{ $errors->has('vision') ? 'is-invalid' : '' }}" name="vision"
                              id="vision" maxlength="{{ \App\Curriculum::MAX_LENGTH_OF_VISION }}"
                              required>{{ old('vision') }}</textarea>
                    @if($errors->has('vision'))
                        <span class="text-danger">{{ $errors->first('vision') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.curriculum.fields.vision_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="mission">{{ trans('crud.curriculum.fields.mission') }}</label>
                    <textarea class="form-control {{ $errors->has('mission') ? 'is-invalid' : '' }}" name="mission"
                              id="mission" maxlength="{{ \App\Curriculum::MAX_LENGTH_OF_MISSION }}"
                              required>{{ old('mission') }}</textarea>
                    @if($errors->has('mission'))
                        <span class="text-danger">{{ $errors->first('mission') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.curriculum.fields.mission_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="purpose">{{ trans('crud.curriculum.fields.purpose') }}</label>
                    <textarea class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose"
                              id="purpose" maxlength="{{ \App\Curriculum::MAX_LENGTH_OF_PURPOSE }}"
                              required>{{ old('purpose') }}</textarea>
                    @if($errors->has('purpose'))
                        <span class="text-danger">{{ $errors->first('purpose') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.curriculum.fields.purpose_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="calendars">{{ trans('crud.curriculum.fields.calendars') }}</label>
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
                    <span class="help-block">{{ trans('crud.curriculum.fields.calendars_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="document">{{ trans('crud.curriculum.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.curriculum.fields.document_helper') }}</span>
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

        Dropzone.options.documentDropzone = {
            url: '{{ route('school.curricula.storeMedia', ['school_slug' => $school_slug]) }}',
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
                    @if(isset($curriculum) && $curriculum->document)
                let file = {!! json_encode($curriculum->document) !!}
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
    </script>
@endsection
