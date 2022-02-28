@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.school.title_singular') }}
        </div>

        <div class="card-body">
            <form id="schoolForm" method="POST" action="{{ route("admin.schools.update", ['school' => $school->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                <input type="hidden" name="year" id="year" value="{{ request()->get('year', date('Y')) }}"
                       readonly="readonly">
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.school.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                           maxlength="191"
                           name="name"
                           id="name" value="{{ old('name', $school->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="level" class="required">{{ trans('crud.school.fields.level') }}</label>
                    <select class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}" name="level" id="level">
                        <option value
                                disabled {{ old('level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\School::LEVEL_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('level', $school->level) == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                              id="vision">{{ old('vision', $schoolProfile->vision ?? '') }}</textarea>
                    @if($errors->has('vision'))
                        <span class="text-danger">{{ $errors->first('vision') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.vision_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="status" class="required">{{ trans('crud.school.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status"
                            id="status">
                        <option value
                                disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\School::STATUS_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('status', $school->status) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="province">{{ trans('crud.city.fields.province') }}</label>
                    <select class="form-control select2 {{ $errors->has('province') ? 'is-invalid' : '' }}"
                            name="province" id="province" required>
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        @foreach($provinces as $code => $province)
                            <option value="{{ $code }}">
                                {{ $province }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('province'))
                        <span class="text-danger">{{ $errors->first('province') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.city.fields.province_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="city">{{ trans('crud.school.fields.city') }}</label>
                    <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city"
                            id="city" required disabled>
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                    </select>
                    @if($errors->has('city'))
                        <span class="text-danger">{{ $errors->first('city') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.city_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="address">{{ trans('crud.school.fields.address') }}</label>
                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address"
                              id="address" required>{{ old('address', $school->address) }}</textarea>
                    @if($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.address_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="phone">{{ trans('crud.school.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone"
                           id="phone" value="{{ old('phone', $school->phone) }}"
                           data-inputmask="'mask': ['9{10,20}'], 'placeholder': ''"
                           data-mask required>
                    @if($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.phone_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('crud.school.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                           name="email" id="email" value="{{ old('email', $school->email) }}" required>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.email_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="website">{{ trans('crud.school.fields.website') }}</label>
                    <input class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" type="text"
                           maxlength="191" name="website" id="website" value="{{ old('website', $school->website) }}">
                    @if($errors->has('website'))
                        <span class="text-danger">{{ $errors->first('website') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.website_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="total_students">{{ trans('crud.school.fields.total_students') }}</label>
                    <input class="form-control {{ $errors->has('total_students') ? 'is-invalid' : '' }}" type="number"
                           name="total_students" id="total_students"
                           value="{{ old('total_students', $schoolProfile->total_students ?? '') }}" step="1">
                    @if($errors->has('total_students'))
                        <span class="text-danger">{{ $errors->first('total_students') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_students_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="total_teachers">{{ trans('crud.school.fields.total_teachers') }}</label>
                    <input class="form-control {{ $errors->has('total_teachers') ? 'is-invalid' : '' }}" type="number"
                           name="total_teachers" id="total_teachers"
                           value="{{ old('total_teachers', $schoolProfile->total_teachers ?? '') }}" step="1">
                    @if($errors->has('total_teachers'))
                        <span class="text-danger">{{ $errors->first('total_teachers') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_teachers_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="total_land_area">{{ trans('crud.school.fields.total_land_area') }}</label>
                    <input class="form-control {{ $errors->has('total_land_area') ? 'is-invalid' : '' }}" type="number"
                           name="total_land_area" id="total_land_area"
                           value="{{ old('total_land_area', $schoolProfile->total_land_area ?? '') }}" step="1"
                           >
                    @if($errors->has('total_land_area'))
                        <span class="text-danger">{{ $errors->first('total_land_area') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_land_area_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="total_building_area">{{ trans('crud.school.fields.total_building_area') }}</label>
                    <input class="form-control {{ $errors->has('total_building_area') ? 'is-invalid' : '' }}"
                           type="number"
                           name="total_building_area" id="total_building_area"
                           value="{{ old('total_building_area', $schoolProfile->total_building_area ?? '') }}" step="1">
                    @if($errors->has('total_building_area'))
                        <span class="text-danger">{{ $errors->first('total_building_area') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.total_building_area_helper') }}</span>
                </div>

                <div class="form-group">
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
                </div>
                {{--@if($school->user && $school->user->approved)
                    <div class="form-group">
                        <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="approved" value="0">
                            <input class="form-check-input" type="checkbox" name="approved" id="approved"
                                   value="1" {{ $school->user->approved || old('approved', 0) === 1 ? 'checked' : '' }}>
                            <label class="form-check-label"
                                   for="approved">{{ trans('crud.user.fields.approved') }}</label>
                        </div>
                        @if($errors->has('approved'))
                            <span class="text-danger">{{ $errors->first('approved') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.user.fields.approved_helper') }}</span>
                    </div>
                @endif--}}

                <div class="form-group">
                    <label for="approval_condition"
                           class="required">{{ trans('crud.school.fields.approval_condition') }}</label>
                    <select class="form-control {{ $errors->has('approval_condition') ? 'is-invalid' : '' }}"
                            name="approval_condition"
                            id="approval_condition" required>
                        <option value
                                disabled {{ old('approval_condition', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\School::APPROVAL_CONDITION_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('approval_condition', $school->approval_condition) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('approval_condition'))
                        <span class="text-danger">{{ $errors->first('approval_condition') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.approval_condition_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="approval_time" class="required">{{ trans('crud.school.fields.approval_time') }}</label>
                    <select class="form-control {{ $errors->has('approval_time') ? 'is-invalid' : '' }}"
                            name="approval_time"
                            id="approval_time" required>
                        <option value
                                disabled {{ old('approval_time', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @for($i = 1; $i <= 48; $i++)
                            <option
                                value="{{ $i }}" {{ old('approval_time', $school->approval_time) == $i ? 'selected' : '' }}>{{ $i }}
                                Bulan
                            </option>
                        @endfor
                    </select>
                    @if($errors->has('approval_time'))
                        <span class="text-danger">{{ $errors->first('approval_time') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.approval_time_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="environmental_status_id" class="required">{{ trans('crud.school.fields.environmental_status') }}</label>
                    <select class="form-control {{ $errors->has('environmental_status_id') ? 'is-invalid' : '' }}" name="environmental_status_id" id="environmental_status_id"
                            required>
                        <option value
                                disabled {{ old('environmental_status_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(\App\EnvironmentalStatus::query()->get() as $key => $environmental_status)
                            <option
                                value="{{ $environmental_status->id }}" {{ old('environmental_status_id', $schoolProfile->environmental_status_id) == $environmental_status->id ? 'selected' : '' }}>{{ $environmental_status->name }}</option>
                        @endforeach

                    </select>
                    @if($errors->has('environmental_status_id'))
                        <span class="text-danger">{{ $errors->first('environmental_status_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.school.fields.environmental_status_helper') }}</span>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script>
        $(function () {
            const selectProvince = $('select#province');
            const selectCity = $('select#city');

            let newOption;

            selectProvince.change(function () {
                selectCity.attr('disabled');

                axios.post('{{ route('api.cities') }}', {
                    province: selectProvince.val(),
                })
                    .then(function (response) {
                        selectCity.empty();

                        let cityVal = "{{ ($school->city ? $school->city->code : old('city')) }}";

                        response.data.forEach(function (data) {
                            let selected = Number(data.id) === Number(cityVal);
                            newOption = new Option(data.text, data.id, selected, selected);
                            if (data.id === '') {
                                newOption.setAttribute('disabled', 'disabled');
                            }
                            selectCity.append(newOption);
                        });

                        selectCity.removeAttr('disabled');
                    })
            });

            selectProvince.val("{{ ($school->city->province ? $school->city->province->code : old('province')) }}").trigger('change');
        });

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
                $('form#schoolForm').find('input[name="logo"]').remove();
                $('form#schoolForm').append('<input type="hidden" name="logo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form#schoolForm').find('input[name="logo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($school) && $school->logo)
                let file = {!! json_encode($school->logo) !!}
                    this.options.addedfile.call(this, file);
                this.options.thumbnail.call(this, file, '{{ $school->logo->getUrl() }}');
                file.previewElement.classList.add('dz-complete');
                $('form#schoolForm').append('<input type="hidden" name="logo" value="' + file.file_name + '">');
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
                $('form#schoolForm').find('input[name="photo"]').remove();
                $('form#schoolForm').append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form#schoolForm').find('input[name="photo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($schoolProfile) && $schoolProfile->photo)
                let file = {!! json_encode($schoolProfile->photo) !!}
                    this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                $('form#schoolForm').append('<input type="hidden" name="photo" value="' + file.file_name + '">');
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
