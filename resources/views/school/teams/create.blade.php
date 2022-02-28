@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.team.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.teams.store", ['school_slug' => $school_slug]) }}"
                  enctype="multipart/form-data" id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.team.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                           maxlength="{{ \App\Team::MAX_LENGTH_OF_NAME }}" name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="team_status_id">{{ trans('crud.team.fields.team_status') }}</label>
                    <select class="form-control select2 {{ $errors->has('team_status_id') ? 'is-invalid' : '' }}"
                            name="team_status_id" id="team_status_id"
                            required>
                        @foreach($teamStatuses as $id => $teamStatus)
                            <option
                                value="{{ $id }}" {{ old('team_status_id') == $id ? 'selected' : '' }}>{{ $teamStatus }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team_status_id'))
                        <span class="text-danger">{{ $errors->first('team_status_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.team_status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="gender">{{ trans('crud.team.fields.gender') }}</label>
                    <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender"
                            id="gender" required>
                        <option value
                                disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Team::GENDER_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('gender'))
                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.gender_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="birth_date">{{ trans('crud.team.fields.birth_date') }}</label>
                    <input class="form-control date {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#birth_date" autocomplete="off"
                           name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required>
                    @if($errors->has('birth_date'))
                        <span class="text-danger">{{ $errors->first('birth_date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.birth_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.team.fields.aspect') }}</label>
                    <select class="form-control select2 {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id"
                            required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id') == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect_id'))
                        <span class="text-danger">{{ $errors->first('aspect_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="work_group_id">{{ trans('crud.team.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group_id') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            required>
                    </select>
                    @if($errors->has('work_group_id'))
                        <span class="text-danger">{{ $errors->first('work_group_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="job_description">{{ trans('crud.team.fields.job_description') }}</label>
                    <textarea class="form-control {{ $errors->has('job_description') ? 'is-invalid' : '' }}"
                              name="job_description" id="job_description"
                    >{{ old('job_description') }}</textarea>
                    @if($errors->has('job_description'))
                        <span class="text-danger">{{ $errors->first('job_description') }}</span>
                    @endif
                    <span
                        class="help-block">{{ trans('crud.team.fields.job_description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="team_position_id">{{ trans('crud.team.fields.team_position') }}</label>
                    <select class="form-control select2 {{ $errors->has('team_position_id') ? 'is-invalid' : '' }}"
                            name="team_position_id" id="team_position_id"
                            required>
                        @foreach($teamPositions as $id => $teamPosition)
                            <option
                                value="{{ $id }}" {{ old('team_position_id') == $id ? 'selected' : '' }}>{{ $teamPosition }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team_position_id'))
                        <span class="text-danger">{{ $errors->first('team_position_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.team_position_helper') }}</span>
                </div>
                <div id="inputAnotherPosition" class="form-group" style="display: none;">
                    <label class="required"
                           for="another_position">{{ trans('crud.team.fields.another_position') }}</label>
                    <input class="form-control {{ $errors->has('another_position') ? 'is-invalid' : '' }}" type="text"
                           maxlength="191" name="another_position"
                           id="another_position" value="{{ old('another_position', '') }}">
                    @if($errors->has('another_position'))
                        <span class="text-danger">{{ $errors->first('another_position') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.another_position_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="document">
                        {{ trans('global.upload') }} {{ trans('crud.team.fields.document') }}
                    </label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.team.fields.document_helper') }}</span>
                </div>

                <hr>

                <div class="form-group">
                    <label class="required" for="email">{{ trans('crud.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                           name="email" id="email" value="{{ old('email') }}" required>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.user.fields.email_helper') }}</span>
                </div>
                {{--<div class="form-group">
                    <label class="required" for="username">{{ trans('crud.user.fields.username') }}</label>
                    <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text"
                           name="username" id="username" value="{{ old('username') }}" required>
                    @if($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.user.fields.username_helper') }}</span>
                </div>--}}{{--
                <div class="form-group">
                    <label for="password" class="required">{{ __('global.login_password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="required">{{ __('global.confirm_password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required autocomplete="new-password">
                </div> --}}

                <div class="form-group">
                    <input type="hidden" name="add_more" id="add_more" value="{{ old('add_more', 0) }}">
                    <button class="btn btn-warning" type="button" onclick="$('#add_more').val(1); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.add') }} {{ trans('crud.team.title_singular') }}
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
        $ = jQuery;

        $(function () {
            /*const inputUsername = $('input#username');

            inputUsername.change(function () {
                inputUsername.val(inputUsername.val().toLowerCase());
            })*/

            const inputTeamPositionId = $('#team_position_id');

            inputTeamPositionId.change(function () {
                if (Number(inputTeamPositionId.val()) === 7) {
                    $('#inputAnotherPosition').show();
                } else {
                    $('#inputAnotherPosition').hide();

                    if (Number("{{ old('team_position_id') }}") !== 7) {
                        $('#another_position').val('')
                    }
                }
            });

            inputTeamPositionId.val({{ old('team_position_id') }}).trigger('change');
        });

        Dropzone.options.documentDropzone = {
            url: '{{ route('school.teams.storeMedia', ['school_slug' => $school_slug]) }}',
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
                    @if(isset($team) && $team->document)
                let file = {!! json_encode($team->document) !!}
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

        $(function () {
            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');

            selectAspectId.change(function () {
                axios.post('{{ route('api.work-groups') }}', {
                    school: '{{ auth()->user()->isSTC }}',
                    aspect: selectAspectId.val(),
                    year: {{ request()->get('year', date('Y')) }}
                })
                .then(function (response) {
                    selectWorkGroupId.empty();

                    let workGroupIdVal = "{!! old('work_group_id') !!}";

                    response.data.forEach(function (data) {
                        newOption = new Option(data.text, data.id, data.tutor);
                        if (data.id === '') {
                            newOption.setAttribute('selected', 'selected');
                            newOption.setAttribute('disabled', 'disabled');
                        }
                        selectWorkGroupId.append(newOption);
                    });

                    selectWorkGroupId.removeAttr('disabled');

                    if (workGroupIdVal) {
                        selectWorkGroupId.val(workGroupIdVal).trigger('change');
                    }
                });
            });
            selectAspectId.trigger('change')
         });
    </script>
@endsection
