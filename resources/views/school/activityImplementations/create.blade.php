@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.activityImplementation.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.activity-implementations.store", ['school_slug' => $school_slug]) }}" id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.activityImplementation.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}"
                           type="text" data-toggle="datetimepicker" data-target="#date" autocomplete="off"
                           name="date" id="date" value="{{ old('date') }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.activityImplementation.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            required {{ !(auth()->user()->isSTC ?? false) ? 'disabled' : '' }}>
                        @foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ old('work_group_id') == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="activity_id">{{ trans('crud.activityImplementation.fields.activity') }}</label>
                    <select class="form-control select2 {{ $errors->has('activity') ? 'is-invalid' : '' }}"
                            name="activity_id" id="activity_id"
                            required {{ !(auth()->user()->isSTC ?? false) ? 'disabled' : '' }}>
                        @foreach($activities as $id => $activity)
                            <option
                                value="{{ $id }}" {{ old('activity_id') == $id ? 'selected' : '' }}>{{ $activity }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.activity_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="progress">{{ trans('crud.activityImplementation.fields.progress') }}</label>
                    <select class="form-control {{ $errors->has('progress') ? 'is-invalid' : '' }}" name="progress"
                            id="progress"
                            required>
                        <option value
                                disabled {{ old('progress', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\ActivityImplementation::PROGRESS_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('progress', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('progress'))
                        <span class="text-danger">{{ $errors->first('progress') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.progress_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="constraints">{{ trans('crud.activityImplementation.fields.constraints') }}</label>
                    <textarea class="form-control {{ $errors->has('constraints') ? 'is-invalid' : '' }}"
                              name="constraints"
                              id="constraints" required>{{ old('constraints') }}</textarea>
                    @if($errors->has('constraints'))
                        <span class="text-danger">{{ $errors->first('constraints') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.constraints_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="plan">{{ trans('crud.activityImplementation.fields.plan') }}</label>
                    <textarea class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" name="plan"
                              id="plan" required>{{ old('plan') }}</textarea>
                    @if($errors->has('plan'))
                        <span class="text-danger">{{ $errors->first('plan') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.plan_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="document">{{ trans('crud.activityImplementation.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.document_helper') }}</span>
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
    @if(auth()->user()->isSTC ?? false)
        <script>
            $ = jQuery;

            $(function () {
                const selectWorkGroupId = $('select#work_group_id');
                const selectActivityId = $('select#activity_id');

                let newOption;

                selectWorkGroupId.change(function () {
                    axios.post('{{ route('api.activities') }}', {
                        work_group: selectWorkGroupId.val(),
                    })
                        .then(function (response) {
                            selectActivityId.empty();

                            let activityIdVal = Number("{{ old('activity_id', '') }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === activityIdVal), (data.id === activityIdVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectActivityId.append(newOption);
                            });

                            selectActivityId.removeAttr('disabled');
                        })
                });

                selectWorkGroupId.val(Number('{{ old('work_group_id', null) }}')).trigger('change');
            });
        </script>
    @endif
    <script>
        $ = jQuery;

        const formCreate = $('form#formCreate');

        Dropzone.options.documentDropzone = {
            url: '{{ route('school.activity-implementations.storeMedia', ['school_slug' => $school_slug]) }}',
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
                    @if(isset($activityImplementation) && $activityImplementation->document)
                let file = {!! json_encode($activityImplementation->document) !!}
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
        };

        Dropzone.options.letterDropzone = {
            url: '{{ route('school.activity-implementations.storeMedia', ['school_slug' => $school_slug]) }}',
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
                    @if(isset($activityImplementation) && $activityImplementation->letter)
                let file = {!! json_encode($activityImplementation->letter) !!}
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
    </script>
@endsection
