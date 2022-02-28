@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.innovation.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.innovations.store", ['school_slug' => $school_slug]) }}"
                  enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.innovation.fields.name') }}</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           name="name" id="name" placeholder="{{ trans('crud.innovation.fields.name') }}"
                           title="{{ trans('crud.innovation.fields.name') }}"
                           maxlength="{{ \App\Innovation::MAX_LENGTH_OF_NAME }}"
                           value="{{ old('name') }}"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required"
                           for="aspect_id">{{ trans('crud.innovation.fields.aspect') }}</label>
                    <select class="form-control select2 {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        <option value="0"
                                disabled {{ old('aspect_id', '0') === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', '') == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect_id'))
                        <span class="text-danger">{{ $errors->first('aspect_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.innovation.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group_id') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            {{ app()->environment() == 'production' ? 'required' : '' }} disabled="disabled">
                        <option value disabled {{ old('work_group_id', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        {{--@foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ old('work_group_id') == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach--}}
                    </select>
                    @if($errors->has('work_group_id'))
                        <span class="text-danger">{{ $errors->first('work_group_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.work_group_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="activity">{{ trans('crud.innovation.fields.activity') }}</label>
                    <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity"
                              id="activity" maxlength="{{ \App\Innovation::MAX_LENGTH_OF_ACTIVITY }}"
                              required>{{ old('activity') }}</textarea>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.activity_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="tutor">{{ trans('crud.workProgram.fields.tutor') }}</label>
                    <select class="form-control select2 {{ $errors->has('tutor') ? 'is-invalid' : '' }}"
                            name="tutor" id="tutor"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('tutor'))
                        <span class="text-danger">{{ $errors->first('tutor') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workProgram.fields.tutor_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="purpose">{{ trans('crud.innovation.fields.purpose') }}</label>
                    <textarea class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose" id="purpose"
                              maxlength="{{ \App\Innovation::MAX_LENGTH_OF_PURPOSE }}"
                              required>{{ old('purpose') }}</textarea>
                    @if($errors->has('purpose'))
                        <span class="text-danger">{{ $errors->first('purpose') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.purpose_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="team_statuses">{{ trans('crud.activity.fields.team_status') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('team_statuses') ? 'is-invalid' : '' }}"
                            name="team_statuses[]" id="team_statuses" multiple required>
                        @foreach($teamStatuses as $id => $calendar)
                            <option
                                value="{{ $id }}" {{ in_array($id, old('team_statuses', [])) ? 'selected' : '' }}>{{ $calendar }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team_statuses'))
                        <span class="text-danger">{{ $errors->first('team_statuses') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.team_status_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="advantage">{{ trans('crud.innovation.fields.advantage') }}</label>
                    <textarea class="form-control {{ $errors->has('advantage') ? 'is-invalid' : '' }}" name="advantage" id="advantage"
                              maxlength="{{ \App\Innovation::MAX_LENGTH_OF_ADVANTAGE }}"
                              required>{{ old('advantage') }}</textarea>
                    @if($errors->has('advantage'))
                        <span class="text-danger">{{ $errors->first('advantage') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.advantage_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="innovation">{{ trans('crud.innovation.fields.innovation') }}</label>
                    <textarea class="form-control {{ $errors->has('innovation') ? 'is-invalid' : '' }}" name="innovation" id="innovation"
                              maxlength="{{ \App\Innovation::MAX_LENGTH_OF_INNOVATION }}"
                              required>{{ old('innovation') }}</textarea>
                    @if($errors->has('innovation'))
                        <span class="text-danger">{{ $errors->first('innovation') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.innovation_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="photo">{{ trans('crud.innovation.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                         id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.innovation.fields.photo_helper') }}</span>
                </div>

                <div class="form-group">
                    <input type="hidden" name="add_more" id="add_more" value="{{ old('add_more', 0) }}">
                    <button class="btn btn-warning" type="button" onclick="$('#add_more').val(1); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.add') }} {{ trans('crud.innovation.title_singular') }}?
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
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        const formCreate = $('form#formCreate');

        $ = jQuery;

        $(function () {
            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');
            const tutor = $('#tutor');

            let newOption;

            selectAspectId.change(function () {
                axios.post('{{ route('api.work-groups') }}', {
                    school: '{{ auth()->user()->isSTC }}',
                    aspect: selectAspectId.val(),
                    year: {{ request()->get('year', date('Y')) }}
                })
                    .then(function (response) {
                        selectWorkGroupId.empty();

                        let workGroupIdVal = Number("{{ old('work_group_id', '') }}");

                        response.data.forEach(function (data) {
                            newOption = new Option(data.text, data.id);
                            if (data.id === '') {
                                newOption.setAttribute('selected', 'selected');
                                newOption.setAttribute('disabled', 'disabled');
                            }
                            selectWorkGroupId.append(newOption);
                        });

                        selectWorkGroupId.removeAttr('disabled');

                        if (workGroupIdVal) {
                            selectWorkGroupId.val(Number('{{ old('work_group_id', '0') }}')).trigger('change');
                        }
                    });
            });

            selectAspectId.val(Number('{{ old('aspect_id', '0') }}')).trigger('change');

            selectWorkGroupId.change(function () {
                axios.post('{{ route('api.teams') }}', {
                    type: 'pembimbing',
                    work_group_id: selectWorkGroupId.val(),
                    school_id: '{{ auth()->user()->isSTC }}'
                })
                    .then(function (response) {
                        tutor.empty();
                        let tutorVal = "{!! old('tutor', '') !!}";
                        response.data.forEach(function (data) {
                            newOption = new Option(data.text, data.text);
                            if (data.id === '') {
                                newOption.setAttribute('selected', 'selected');
                                newOption.setAttribute('disabled', 'disabled');
                            }
                            tutor.append(newOption);
                        });

                        tutor.removeAttr('disabled');

                        if (tutorVal) {
                            tutor.val(tutorVal).trigger('change');
                        }
                    })
            });
        });

        Dropzone.options.photoDropzone = {
            url: '{{ route('school.innovations.storeMedia', ['school_slug' => $school_slug]) }}',
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
                    @if(isset($innovation) && $innovation->photo)
                let file = {!! json_encode($innovation->photo) !!}
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
