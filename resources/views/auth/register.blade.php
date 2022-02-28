@extends('layouts.app')

@section('content')
    @if(session('success_message'))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="alert alert-success d-flex justify-content-center" role="alert">
                        <div class="media">
                            <img src="{{ asset('img/logo.png') }}" class="mr-3 img-fluid"
                                 style="max-width: 50px;" alt="">
                            <div class="media-body">
                                {!! session('success_message') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('global.register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" id="formRegister">
                            @csrf
                            {{--<div class="form-group row">
                                <label
                                    class="col-md-4 col-form-label text-md-right required"
                                    for="level">{{ trans('crud.school.fields.level') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control select2 {{ $errors->has('level') ? 'is-invalid' : '' }}"
                                            name="level" id="level"
                                            required>
                                        <option value
                                                disabled {{ old('level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\School::LEVEL_SELECT as $key => $label)
                                            <option
                                                value="{{ $key }}" {{ old('level', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('level')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>--}}
                            {{--<div class="form-group row">
                                <label
                                    class="col-md-4 col-form-label text-md-right required"
                                    for="status">{{ trans('crud.school.fields.status') }}</label>
                                <div class="col-md-6">
                                    <select
                                        class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                        name="status"
                                        id="status" required>
                                        <option value
                                                disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\School::STATUS_SELECT as $key => $label)
                                            <option
                                                value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>--}}
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="name">{{ trans('crud.school.fields.name') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           type="text" name="name" id="name" value="{{ old('name', '') }}"
                                           placeholder="{{ trans('global.input') }} {{ trans('crud.school.fields.name') }}"
                                           maxlength="{{ \App\User::MAX_LENGTH_OF_NAME }}" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="province">{{ trans('crud.city.fields.province') }}</label>
                                <div class="col-md-6">
                                    <select
                                        class="form-control select2 {{ $errors->has('province') ? 'is-invalid' : '' }}"
                                        name="province" id="province" required>
                                        <option value disabled {{ old('province', null) === null ? 'selected' : '' }}>
                                            {{ trans('global.pleaseSelect') }} {{ trans('crud.city.fields.province') }}
                                        </option>
                                        @foreach(\App\Province::query()->orderBy('name')->get() as $province)
                                            <option
                                                value="{{ $province->code }}" {{ old('province') == $province->code ? 'selected' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="city">{{ trans('crud.school.fields.city') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                            name="city" id="city" required disabled>
                                        <option value disabled {{ old('city', '') === '' ? 'selected' : '' }}>
                                            {{ trans('global.pleaseSelect') }} {{ trans('crud.school.fields.city') }}
                                        </option>
                                    </select>
                                    @error('city')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="address">{{ trans('crud.school.fields.address') }}</label>
                                <div class="col-md-6">
                                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                          name="address" id="address"
                                          placeholder="{{ trans('global.input') }} {{ trans('crud.school.fields.address') }}"
                                          required>{{ old('address') }}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="environmental_status">{{ trans('crud.school.fields.environmental_status') }}</label>
                                <div class="col-md-6">
                                    <select
                                        class="form-control {{ $errors->has('environmental_status') ? 'is-invalid' : '' }}"
                                        name="environmental_status" id="environmental_status" required>
                                        <option value
                                                disabled {{ old('environmental_status', '') === '' ? 'selected' : '' }}>
                                            {{ trans('global.pleaseSelect') }} {{ trans('crud.school.fields.environmental_status') }}
                                        </option>
                                        @foreach(\App\EnvironmentalStatus::query()->get() as $environmental_status)
                                            <option
                                                value="{{ $environmental_status->slug }}" {{ old('environmental_status') == $environmental_status->slug ? 'selected' : '' }}>{{ $environmental_status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('environmental_status')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="phone">{{ trans('crud.school.fields.phone') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                           type="text" name="phone" id="phone" value="{{ old('phone', '') }}"
                                           placeholder="{{ trans('global.input') }} {{ trans('crud.school.fields.phone') }}"
                                           data-inputmask="'mask': ['9{10,20}'], 'placeholder': ''"
                                           data-mask required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="email">{{ trans('crud.school.fields.email') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                           type="email" name="email" id="email" value="{{ old('email') }}"
                                           placeholder="{{ trans('global.input') }} {{ trans('crud.school.fields.email') }}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('global.login_password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           placeholder="{{ trans('global.input') }} {{ __('global.login_password') }}" required
                                           autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('global.confirm_password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password"
                                           placeholder="{{ trans('global.input') }} {{ __('global.confirm_password') }}">
                                </div>
                            </div>
                            {{--<div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="vision">{{ trans('crud.school.fields.vision') }}</label>
                                <div class="col-md-6">
                                <textarea class="form-control {{ $errors->has('vision') ? 'is-invalid' : '' }}"
                                          name="vision"
                                          id="vision" required>{{ old('vision') }}</textarea>
                                    @error('vision')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="total_students">{{ trans('crud.school.fields.total_students') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control {{ $errors->has('total_students') ? 'is-invalid' : '' }}"
                                           type="number" name="total_students" id="total_students"
                                           value="{{ old('total_students', '') }}" step="1" min="1" required>
                                    @error('total_students')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="total_teachers">{{ trans('crud.school.fields.total_teachers') }}</label>
                                <div class="col-md-6">
                                    <input class="form-control {{ $errors->has('total_teachers') ? 'is-invalid' : '' }}"
                                           type="number" name="total_teachers" id="total_teachers"
                                           value="{{ old('total_teachers', '') }}" step="1" min="1" required>
                                    @error('total_teachers')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="total_land_area">{{ trans('crud.school.fields.total_land_area') }}</label>
                                <div class="col-md-6">
                                    <input
                                        class="form-control {{ $errors->has('total_land_area') ? 'is-invalid' : '' }}"
                                        type="number" name="total_land_area" id="total_land_area"
                                        value="{{ old('total_land_area', '') }}" step="1" min="1" required>
                                    @error('total_land_area')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right required"
                                       for="total_building_area">{{ trans('crud.school.fields.total_building_area') }}</label>
                                <div class="col-md-6">
                                    <input
                                        class="form-control {{ $errors->has('total_building_area') ? 'is-invalid' : '' }}"
                                        type="number" name="total_building_area" id="total_building_area"
                                        value="{{ old('total_building_area', '') }}" step="1" min="1" required>
                                    @error('total_building_area')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>--}}
                            <div class="form-group row">
                                <label class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="checkbox"
                                               name="checkbox" required>
                                        <label class="form-check-label font-italic" for="checkbox">
                                            Dengan mengirim maka Anda menyetujui syarat dan ketentuan yang berlaku di
                                            sistem GoGreenSchool
                                        </label>
                                        @error('total_building_area')
                                        <span class="invalid-feedback"
                                              role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </label>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('global.send') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">
    <style>
        .select2 {
            max-width: 100%;
            width: 100%;
        }

        .select2-container--open {
            z-index: 9999;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>
        $(function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('[data-mask]').inputmask();

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

                        let cityVal = Number("{{ old('city', '') }}");

                        response.data.forEach(function (data) {
                            newOption = new Option(data.text, data.id, (Number(data.id) === cityVal), (Number(data.id) === cityVal));
                            if (data.id === '') {
                                newOption.setAttribute('disabled', 'disabled');
                            }
                            selectCity.append(newOption);
                        });

                        if (response.data.length > 1) {
                            selectCity.removeAttr('disabled');
                        }
                    })
            });

            selectProvince.val("{{ old('province', null) }}").trigger('change');
        });
    </script>
@endsection
