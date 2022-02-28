@extends('layouts.school')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.infrastructure.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.infrastructures.store", ['school_slug' => $school_slug]) }}"
                  enctype="multipart/form-data" id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.infrastructure.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                           name="name" id="name" value="{{ old('name', '') }}"
                           maxlength="{{ \App\Infrastructure::MAX_LENGTH_OF_NAME }}" required>
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
                    <label class="required"
                           for="work_group_id">{{ trans('crud.infrastructure.fields.work_group') }}</label>
                    <select class="form-control {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id" required>
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.work_group_helper') }}</span>
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
                              id="function" maxlength="{{ \App\Infrastructure::MAX_LENGTH_OF_FUNCTION }}"
                              required>{{ old('function') }}</textarea>
                    @if($errors->has('function'))
                        <span class="text-danger">{{ $errors->first('function') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.function_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="pic">{{ trans('crud.infrastructure.fields.pic') }}</label>
                    <select class="form-control select2 {{ $errors->has('pic') ? 'is-invalid' : '' }}"
                            name="pic" id="pic"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('pic'))
                        <span class="text-danger">{{ $errors->first('pic') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.infrastructure.fields.pic_helper') }}</span>
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
                    <input type="hidden" name="add_more" id="add_more" value="{{ old('add_more', 0) }}">
{{--                    <button class="btn btn-warning" type="button" onclick="$('#add_more').val(1); setTimeout(function() {--}}
{{--                      $('#formCreate').submit();--}}
{{--                    }, 300)">--}}
{{--                        {{ trans('global.add') }} {{ trans('crud.infrastructure.title_singular') }}?--}}
{{--                    </button>--}}
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

        Dropzone.options.photoDropzone = {
            url: '{{ route('school.infrastructures.storeMedia', ['school_slug' => $school_slug]) }}',
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


        $(function () {
            const selectedCompiler = $('#pic');
            const selectedAspect = $('#aspect_id');
            const selectedWorkGroup = $('#work_group_id');

            axios.post('{{ route('api.teams') }}', {
                type: 'pembimbing',
                school_id: '{{ auth()->user()->isSTC }}'
            })
                .then(function (response) {
                    let selectedCompilerVal = "{!! old('pic', '') !!}";
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
            selectedAspect.change(function(){
                axios.post('{{ route('api.work-groups') }}', {
                    aspect: selectedAspect.val(),
                    school: '{{ auth()->user()->isSTC }}',
                    year: {{ request()->get('year', date('Y')) }}
                }).then(function (response) {
                    let selectedWorkGroupVal = "{!! old('work_group_id', '') !!}";
                    selectedWorkGroup.empty();
                    response.data.forEach(function (data) {
                        newOption = new Option(data.text, data.id);
                        if (data.id === '') {
                            newOption.setAttribute('selected', 'selected');
                            newOption.setAttribute('disabled', 'disabled');
                        }
                        selectedWorkGroup.append(newOption);
                    });

                    selectedWorkGroup.removeAttr('disabled');

                    if(selectedWorkGroupVal){
                        selectedWorkGroup.val(selectedWorkGroupVal).trigger('change');
                        console.log(1)
                    }
                        console.log(2)
                })
            })
            selectedAspect.trigger('change');
        });
    </script>
@endsection
