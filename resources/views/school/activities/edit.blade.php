@extends('layouts.school')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.activity.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.activities.update", ['school_slug' => $school_slug, $activity->id]) }}"
                  id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.activity.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                           name="name" id="name" value="{{ old('name', $activity->name) }}"
                           maxlength="{{ \App\Activity::MAX_LENGTH_OF_NAME }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.activity.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#date" autocomplete="off"
                           name="date" id="date" value="{{ old('date', $activity->date) }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.workGroup.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id" required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', $activity->work_group->aspect_id) == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect'))
                        <span class="text-danger">{{ $errors->first('aspect') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.activity.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id" required>
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.work_group_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="activity">{{ trans('crud.activity.fields.activity') }}</label>
                    <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity"
                              id="activity" required>{{ old('activity', $activity->activity) }}</textarea>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.activity_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="advantage">{{ trans('crud.activity.fields.advantage') }}</label>
                    <textarea class="form-control {{ $errors->has('advantage') ? 'is-invalid' : '' }}" name="advantage"
                              id="advantage" required>{{ old('advantage', $activity->advantage) }}</textarea>
                    @if($errors->has('advantage'))
                        <span class="text-danger">{{ $errors->first('advantage') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.advantage_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="behavioral">{{ trans('crud.activity.fields.behavioral') }}</label>
                    <textarea class="form-control {{ $errors->has('behavioral') ? 'is-invalid' : '' }}"
                              name="behavioral" id="behavioral" required>{{ old('behavioral', $activity->behavioral) }}</textarea>
                    @if($errors->has('behavioral'))
                        <span class="text-danger">{{ $errors->first('behavioral') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.behavioral_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="physical">{{ trans('crud.activity.fields.physical') }}</label>
                    <textarea class="form-control {{ $errors->has('physical') ? 'is-invalid' : '' }}" name="physical"
                              id="physical" required>{{ old('physical', $activity->physical) }}</textarea>
                    @if($errors->has('physical'))
                        <span class="text-danger">{{ $errors->first('physical') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.physical_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="team_statuses">{{ trans('crud.activity.fields.team_status') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('team_statuses') ? 'is-invalid' : '' }}"
                            name="team_statuses[]" id="team_statuses" multiple required>
                        @foreach($teamStatuses as $id => $team_status)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('team_statuses', [])) || $activity->team_statuses->contains($id)) ? 'selected' : '' }}>{{ $team_status }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team_statuses'))
                        <span class="text-danger">{{ $errors->first('team_statuses') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.team_status_helper') }}</span>
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
                    <label class="required" for="document">{{ trans('crud.activity.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.document_helper') }}</span>

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
        $ = jQuery;

        const formEdit = $('form#formEdit');

        $(function () {
            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');
            const tutor = $('#tutor');

            selectAspectId.change(function () {
                if (selectAspectId.val()) {
                    let newOption;

                    selectWorkGroupId.attr('disabled');

                    axios.post('{{ route('api.work-groups') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        aspect: selectAspectId.val(),
                    })
                        .then(function (response) {
                            selectWorkGroupId.empty();
                            tutor.empty();

                            let workGroupIdVal = Number("{{ old('work_group_id', $activity->work_group_id) }}");

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
                                selectWorkGroupId.val(('{{ old('work_group_id', $activity->work_group_id) }}')).trigger('change');
                            }
                        })
                }
            });

            selectWorkGroupId.change(function () {
                if(selectWorkGroupId.val()){
                    axios.post('{{ route('api.teams') }}', {
                        type: 'pembimbing',
                        work_group_id: selectWorkGroupId.val(),
                        school_id: '{{ auth()->user()->isSTC }}'
                    })
                        .then(function (response) {
                            tutor.empty();
                            let tutorVal = Number("{{ old('tutor', '') }}");
                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.text);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                tutor.append(newOption);
                            });

                            tutor.removeAttr('disabled');

                            tutor.val(('{{ old('tutor', $activity->tutor) }}')).trigger('change');
                        })
                }
            });

            selectAspectId.val(('{{ old('aspect_id', $activity->work_group->aspect_id) }}')).trigger('change');
            tutor.val(('{{ old('tutor', $activity->tutor) }}')).trigger('change');
        });

        Dropzone.options.documentDropzone = {
            url: "{{ route('school.activities.storeMedia', ['school_slug' => $school_slug]) }}",
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
                    @if(isset($activity) && $activity->document)
                let file = {!! json_encode($activity->document) !!}
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
    </script>
@endsection
