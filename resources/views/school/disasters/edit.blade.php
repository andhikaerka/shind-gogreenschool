@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.disaster.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.disasters.update", ['school_slug' => $school_slug, $disaster->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                {{--<div class="form-group">
                    <label class="required" for="threats">{{ trans('crud.disaster.fields.threats') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2-tags {{ $errors->has('threats') ? 'is-invalid' : '' }}"
                            name="threats[]" id="threats" multiple required>
                        @foreach($threats as $id => $threat)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('threats', [])) || $disaster->threats->contains($id)) ? 'selected' : '' }}>{{ $threat }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('threats'))
                        <span class="text-danger">{{ $errors->first('threats') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.threats_helper') }}</span>
                </div>--}}
                <div class="form-group">
                    <label class="required" for="threat">{{ trans('crud.disaster.fields.threat') }}</label>
                    <textarea class="form-control {{ $errors->has('threat') ? 'is-invalid' : '' }}" name="threat"
                              id="threat" maxlength="{{ \App\Disaster::MAX_LENGTH_OF_THREAT }}"
                              required>{{ old('threat', $disaster->threat) }}</textarea>
                    @if($errors->has('threat'))
                        <span class="text-danger">{{ $errors->first('threat') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.threat_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="potential">{{ trans('crud.disaster.fields.potential') }}</label>
                    <textarea class="form-control {{ $errors->has('potential') ? 'is-invalid' : '' }}" name="potential"
                              id="potential" maxlength="{{ \App\Disaster::MAX_LENGTH_OF_POTENTIAL }}"
                              required>{{ old('potential', $disaster->potential) }}</textarea>
                    @if($errors->has('potential'))
                        <span class="text-danger">{{ $errors->first('potential') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.potential_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="anticipation">{{ trans('crud.disaster.fields.anticipation') }}</label>
                    <textarea class="form-control {{ $errors->has('anticipation') ? 'is-invalid' : '' }}" name="anticipation"
                              id="anticipation"
                              required>{{ old('anticipation', $disaster->anticipation) }}</textarea>
                    @if($errors->has('anticipation'))
                        <span class="text-danger">{{ $errors->first('anticipation') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.anticipation_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="vulnerability">{{ trans('crud.disaster.fields.vulnerability') }}</label>
                    <textarea class="form-control {{ $errors->has('vulnerability') ? 'is-invalid' : '' }}"
                              name="vulnerability" id="vulnerability"
                              maxlength="{{ \App\Disaster::MAX_LENGTH_OF_VULNERABILITY }}"
                              required>{{ old('vulnerability', $disaster->vulnerability) }}</textarea>
                    @if($errors->has('vulnerability'))
                        <span class="text-danger">{{ $errors->first('vulnerability') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.vulnerability_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="impact">{{ trans('crud.disaster.fields.impact') }}</label>
                    <textarea class="form-control {{ $errors->has('impact') ? 'is-invalid' : '' }}" name="impact"
                              id="impact" maxlength="{{ \App\Disaster::MAX_LENGTH_OF_IMPACT }}"
                              required>{{ old('impact', $disaster->impact) }}</textarea>
                    @if($errors->has('impact'))
                        <span class="text-danger">{{ $errors->first('impact') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.impact_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="photo">{{ trans('crud.disaster.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                         id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.photo_helper') }}</span>
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

        Dropzone.options.photoDropzone = {
            url: '{{ route('school.disasters.storeMedia', ['school_slug' => $school_slug]) }}',
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
                formEdit.find('input[name="photo"]').remove();
                formEdit.append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formEdit.find('input[name="photo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($disaster) && $disaster->photo)
                let file = {!! json_encode($disaster->photo) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formEdit.append('<input type="hidden" name="photo" value="' + file.file_name + '">');
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
