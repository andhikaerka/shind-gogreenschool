@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.infrastructure.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.infrastructures.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.infrastructure.fields.school') }}</label>
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
                    <span class="help-block">{{ trans('crud.infrastructure.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.infrastructure.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" maxlength="191"
                           name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.infrastructure.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id" required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id') == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect'))
                        <span class="text-danger">{{ $errors->first('aspect') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="total">{{ trans('crud.infrastructure.fields.total') }}</label>
                    <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number"
                           name="total" id="total" value="{{ old('total', '') }}" step="1" min="1" required>
                    @if($errors->has('total'))
                        <span class="text-danger">{{ $errors->first('total') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.total_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="function">{{ trans('crud.infrastructure.fields.function') }}</label>
                    <textarea class="form-control {{ $errors->has('function') ? 'is-invalid' : '' }}" name="function"
                              id="function" required>{{ old('function') }}</textarea>
                    @if($errors->has('function'))
                        <span class="text-danger">{{ $errors->first('function') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.function_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="photo">{{ trans('crud.infrastructure.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                         id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.photo_helper') }}</span>
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
            url: '{{ route('admin.infrastructures.storeMedia') }}',
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
                    @if(isset($infrastructure) && $infrastructure->photo)
                let file = {!! json_encode($infrastructure->photo) !!}
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
@endsection
