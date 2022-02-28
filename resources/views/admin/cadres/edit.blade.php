@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.cadre.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.cadres.update", [$cadre->id]) }}" enctype="multipart/form-data"
                  id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.workGroup.fields.school') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}"
                            name="school_id" id="school_id" required>
                        @foreach($schools as $id => $school)
                            <option
                                value="{{ $id }}" {{ ($cadre->work_group->school ? $cadre->work_group->school->id : old('school_id')) == $id ? 'selected' : '' }}>{{ $school }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('school'))
                        <span class="text-danger">{{ $errors->first('school') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="work_group_id">{{ trans('crud.cadre.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id" required>
                        @foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ ($cadre->work_group ? $cadre->work_group->id : old('work_group_id')) == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.user.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" maxlength="191"
                           name="name"
                           id="name" value="{{ old('name', $cadre->user->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="gender">{{ trans('crud.cadre.fields.gender') }}</label>
                    <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender"
                            id="gender" required>
                        <option value
                                disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Cadre::GENDER_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('gender', $cadre->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('gender'))
                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.gender_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="class">{{ trans('crud.cadre.fields.class') }}</label>
                    <select class="form-control {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class" id="class"
                            required>
                        <option value
                                disabled {{ old('class', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    </select>
                    @if($errors->has('class'))
                        <span class="text-danger">{{ $errors->first('class') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.class_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="phone">{{ trans('crud.cadre.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone"
                           id="phone" value="{{ old('phone', $cadre->phone) }}"
                           data-inputmask="'mask': ['9{10,20}'], 'placeholder': ''"
                           data-mask required>
                    @if($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.phone_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="birth_date">{{ trans('crud.cadre.fields.birth_date') }}</label>
                    <input class="form-control date {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#birth_date"
                           name="birth_date" id="birth_date" value="{{ old('birth_date', $cadre->birth_date) }}"
                           required>
                    @if($errors->has('birth_date'))
                        <span class="text-danger">{{ $errors->first('birth_date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.birth_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="address">{{ trans('crud.cadre.fields.address') }}</label>
                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address"
                              id="address" required>{{ old('address', $cadre->address) }}</textarea>
                    @if($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="hobby">{{ trans('crud.cadre.fields.hobby') }}</label>
                    <textarea class="form-control {{ $errors->has('hobby') ? 'is-invalid' : '' }}" name="hobby"
                              id="hobby" required>{{ old('hobby', $cadre->hobby) }}</textarea>
                    @if($errors->has('hobby'))
                        <span class="text-danger">{{ $errors->first('hobby') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.hobby_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="position">{{ trans('crud.cadre.fields.position') }}</label>
                    <select class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" name="position"
                            id="position" required>
                        <option value
                                disabled {{ old('position', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Cadre::POSITION_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('position', $cadre->position) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('position'))
                        <span class="text-danger">{{ $errors->first('position') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.position_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="photo">{{ trans('crud.cadre.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                         id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.photo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="letter">{{ trans('crud.cadre.fields.letter') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('letter') ? 'is-invalid' : '' }}"
                         id="letter-dropzone">
                    </div>
                    @if($errors->has('letter'))
                        <span class="text-danger">{{ $errors->first('letter') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.cadre.fields.letter_helper') }}</span>
                </div>

                <hr>

                <div class="form-group">
                    <label class="required" for="email">{{ trans('crud.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                           name="email" id="email" value="{{ old('email', $cadre->user->email) }}" required>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="username">{{ trans('crud.user.fields.username') }}</label>
                    <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text"
                           name="username" id="username" value="{{ old('username', $cadre->user->username) }}" required>
                    @if($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.user.fields.username_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="password" class="required">{{ __('global.login_password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="required">{{ __('global.confirm_password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           autocomplete="new-password">
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
        $(function () {
            const inputUsername = $('input#username');

            inputUsername.change(function () {
                inputUsername.val(inputUsername.val().toLowerCase());
            })
        });

        const formEdit = $('form#formEdit');

        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.cadres.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
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
                    @if(isset($cadre) && $cadre->photo)
                let file = {!! json_encode($cadre->photo) !!}
                        this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, '{{ $cadre->photo->getUrl() }}');
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
        };

        Dropzone.options.letterDropzone = {
            url: '{{ route('admin.cadres.storeMedia') }}',
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
                formEdit.find('input[name="letter"]').remove();
                formEdit.append('<input type="hidden" name="letter" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formEdit.find('input[name="letter"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($cadre) && $cadre->letter)
                let file = {!! json_encode($cadre->letter) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formEdit.append('<input type="hidden" name="letter" value="' + file.file_name + '">');
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

    <script>
        $(function () {
            const selectSchoolId = $('select#school_id');
            const selectWorkGroupId = $('select#work_group_id');
            const selectClass = $('select#class');

            let newOption;

            selectSchoolId.change(function () {
                setTimeout(function () {
                    selectWorkGroupId.attr('disabled');

                    axios.post('{{ route('api.work-groups') }}', {
                        school: selectSchoolId.val(),
                    })
                        .then(function (response) {
                            selectWorkGroupId.empty();

                            let workGroupIdVal = Number("{{ old('work_group_id', $cadre->work_group_id) }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === workGroupIdVal), (data.id === workGroupIdVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkGroupId.append(newOption);
                            });

                            selectWorkGroupId.removeAttr('disabled');
                        })
                }, 500);

                setTimeout(function () {
                    selectClass.attr('disabled');

                    axios.post('{{ route('api.classes') }}', {
                        school: selectSchoolId.val(),
                    })
                        .then(function (response) {
                            selectClass.empty();

                            let classVal = "{{ old('class', $cadre->class) }}";

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === classVal), (data.id === classVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectClass.append(newOption);
                            });

                            selectClass.removeAttr('disabled');
                        })
                }, 500)
            });

            selectSchoolId.val(("{{ old('school_id', ($cadre->work_group->school_id ?? '')) }}")).trigger('change');
        });
    </script>
@endsection
