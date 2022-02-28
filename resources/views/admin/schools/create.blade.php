@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.school.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.schools.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.school.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" maxlength="191" name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="level" class="required">{{ trans('crud.school.fields.level') }}</label>
                    <select class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}" name="level" id="level"
                            required>
                        <option value
                                disabled {{ old('level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\School::LEVEL_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('level', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('level'))
                        <span class="text-danger">{{ $errors->first('level') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.level_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="vision">{{ trans('crud.school.fields.vision') }}</label>
                    <textarea class="form-control {{ $errors->has('vision') ? 'is-invalid' : '' }}" name="vision"
                              id="vision" required>{{ old('vision') }}</textarea>
                    @if($errors->has('vision'))
                        <span class="text-danger">{{ $errors->first('vision') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.vision_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="status" class="required">{{ trans('crud.school.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status"
                            id="status" required>
                        <option value
                                disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\School::STATUS_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="city_id">{{ trans('crud.school.fields.city') }}</label>
                    <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id"
                            id="city_id" required>
                        @foreach($cities as $id => $city)
                            <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('city'))
                        <span class="text-danger">{{ $errors->first('city') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.city_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="address">{{ trans('crud.school.fields.address') }}</label>
                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address"
                              id="address" required>{{ old('address') }}</textarea>
                    @if($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="phone">{{ trans('crud.school.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone"
                           id="phone" value="{{ old('phone', '') }}" data-inputmask="'mask': ['9{10,20}'], 'placeholder': ''"
                           data-mask required>
                    @if($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.phone_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('crud.school.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                           name="email" id="email" value="{{ old('email') }}" required>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.email_helper') }}</span>
                </div>
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
                </div>
                <div class="form-group">
                    <label class="required"
                           for="total_students">{{ trans('crud.school.fields.total_students') }}</label>
                    <input class="form-control {{ $errors->has('total_students') ? 'is-invalid' : '' }}" type="number" min="1"
                           name="total_students" id="total_students" value="{{ old('total_students', '') }}" step="1"
                           required>
                    @if($errors->has('total_students'))
                        <span class="text-danger">{{ $errors->first('total_students') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_students_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="total_teachers">{{ trans('crud.school.fields.total_teachers') }}</label>
                    <input class="form-control {{ $errors->has('total_teachers') ? 'is-invalid' : '' }}" type="number" min="1"
                           name="total_teachers" id="total_teachers" value="{{ old('total_teachers', '') }}" step="1"
                           required>
                    @if($errors->has('total_teachers'))
                        <span class="text-danger">{{ $errors->first('total_teachers') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_teachers_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="total_land_area">{{ trans('crud.school.fields.total_land_area') }}</label>
                    <input class="form-control {{ $errors->has('total_land_area') ? 'is-invalid' : '' }}" type="number" min="1"
                           name="total_land_area" id="total_land_area" value="{{ old('total_land_area', '') }}" step="1"
                           required>
                    @if($errors->has('total_land_area'))
                        <span class="text-danger">{{ $errors->first('total_land_area') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_land_area_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="total_building_area">{{ trans('crud.school.fields.total_building_area') }}</label>
                    <input class="form-control {{ $errors->has('total_building_area') ? 'is-invalid' : '' }}"
                           type="number" min="1"
                           name="total_building_area" id="total_building_area"
                           value="{{ old('total_building_area', '') }}" step="1"
                           required>
                    @if($errors->has('total_building_area'))
                        <span class="text-danger">{{ $errors->first('total_building_area') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_building_area_helper') }}</span>
                </div>



                {{--<div class="form-group">
                    <label class="required" for="logo">{{ trans('crud.school.fields.logo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                    </div>
                    @if($errors->has('logo'))
                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.logo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="photo">{{ trans('crud.school.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                         id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.photo_helper') }}</span>
                </div>--}}
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
    {{--<script>
        Dropzone.options.logoDropzone = {
            url: '{{ route('admin.schools.storeMedia') }}',
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
                $('form').find('input[name="logo"]').remove();
                $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form').find('input[name="logo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($school) && $school->logo)
                let file = {!! json_encode($school->logo) !!}
                        this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, '{{ $school->logo->getUrl() }}');
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">');
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
        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.schools.storeMedia') }}',
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
                $('form').find('input[name="photo"]').remove();
                $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form').find('input[name="photo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($school) && $school->photo)
                let file = {!! json_encode($school->photo) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">');
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
    </script>--}}
@endsection
