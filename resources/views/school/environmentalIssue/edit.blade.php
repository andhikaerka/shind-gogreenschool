@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.environmentalIssue.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.environmental-issues.update", ['school_slug' => $school_slug, $environmentalIssue->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="potency">{{ trans('crud.environmentalIssue.fields.potency') }}</label>
                    <input class="form-control {{ $errors->has('potency') ? 'is-invalid' : '' }}" type="text"
                           maxlength="{{ \App\EnvironmentalIssue::MAX_LENGTH_OF_POTENCY }}" name="potency"
                           id="potency" value="{{ old('potency', $environmentalIssue->potency) }}" required>
                    @if($errors->has('potency'))
                        <span class="text-danger">{{ $errors->first('potency') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.environmentalIssue.fields.potency_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.environmentalIssue.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#date" autocomplete="off"
                           name="date" id="date" value="{{ old('date', $environmentalIssue->date) }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.environmentalIssue.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="category">{{ trans('crud.environmentalIssue.fields.category') }}</label>
                    <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}"
                            name="category" id="category"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        <option value="" disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach (\App\EnvironmentalIssue::LIST_OF_CATEGORY as $item)
                            <option {{ old('category', $environmentalIssue->category) === $item ? 'selected' : '' }} value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.environmentalIssue.fields.category_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="problem">{{ trans('crud.environmentalIssue.fields.problem') }}</label>
                    <textarea class="form-control {{ $errors->has('problem') ? 'is-invalid' : '' }}" name="problem"
                              id="problem" maxlength="{{ \App\EnvironmentalIssue::MAX_LENGTH_OF_PROBLEM }}"
                              required>{{ old('problem', $environmentalIssue->problem) }}</textarea>
                    @if($errors->has('problem'))
                        <span class="text-danger">{{ $errors->first('problem') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.environmentalIssue.fields.problem_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="anticipation">{{ trans('crud.environmentalIssue.fields.anticipation') }}</label>
                    <textarea class="form-control {{ $errors->has('anticipation') ? 'is-invalid' : '' }}" name="anticipation"
                              id="anticipation" maxlength="{{ \App\EnvironmentalIssue::MAX_LENGTH_OF_ANTICIPATION }}" required>{{ old('anticipation', $environmentalIssue->anticipation) }}</textarea>
                    @if($errors->has('anticipation'))
                        <span class="text-danger">{{ $errors->first('anticipation') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.environmentalIssue.fields.anticipation_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="compiler">{{ trans('crud.environmentalIssue.fields.compiler') }}</label>
                    <select class="form-control select2 {{ $errors->has('compiler') ? 'is-invalid' : '' }}"
                            name="compiler" id="compiler"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('compiler'))
                        <span class="text-danger">{{ $errors->first('compiler') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.environmentalIssue.fields.compiler_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="document">{{ trans('crud.cadreActivity.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadreActivity.fields.document_helper') }}</span>

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
        Dropzone.options.documentDropzone = {
            url: "{{ route('school.environmental-issues.storeMedia', ['school_slug' => $school_slug]) }}",
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
                const formEdit = $('form#formEdit');
                formEdit.find('input[name="document"]').remove();
                formEdit.append('<input type="hidden" name="document" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form#formEdit').find('input[name="document"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($environmentalIssue) && $environmentalIssue->document)
                let file = {!! json_encode($environmentalIssue->document) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                $('form#formEdit').append('<input type="hidden" name="document" value="' + file.file_name + '">');
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
            const selectedCompiler = $('#compiler');

            axios.post('{{ route('api.teams') }}', {
                type: 'pembimbing',
                school_id: '{{ auth()->user()->isSTC }}'
            })
                .then(function (response) {
                    let selectedCompilerVal = "{!! old('compiler', $environmentalIssue->compiler) !!}";
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
                    }
                })
        })
    </script>
@endsection
