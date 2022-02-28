@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.province.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.provinces.update", [$province->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="code">{{ trans('crud.province.fields.code') }}</label>
                    <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code"
                           id="code" value="{{ old('code', $province->code) }}" required>
                    @if($errors->has('code'))
                        <span class="text-danger">{{ $errors->first('code') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.province.fields.code_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.province.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" maxlength="191" name="name"
                           id="name" value="{{ old('name', $province->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.province.fields.name_helper') }}</span>
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
