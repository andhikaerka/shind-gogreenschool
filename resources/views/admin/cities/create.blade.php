@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.city.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.cities.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="province_id">{{ trans('crud.city.fields.province') }}</label>
                    <select class="form-control select2 {{ $errors->has('province') ? 'is-invalid' : '' }}"
                            name="province_id" id="province_id" required>
                        @foreach($provinces as $id => $province)
                            <option
                                value="{{ $id }}" {{ old('province_id') == $id ? 'selected' : '' }}>{{ $province }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('province'))
                        <span class="text-danger">{{ $errors->first('province') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.city.fields.province_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="code">{{ trans('crud.city.fields.code') }}</label>
                    <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code"
                           id="code" value="{{ old('code', '') }}" required>
                    @if($errors->has('code'))
                        <span class="text-danger">{{ $errors->first('code') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.city.fields.code_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.city.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" maxlength="191" name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.city.fields.name_helper') }}</span>
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
