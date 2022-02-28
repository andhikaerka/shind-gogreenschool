@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.permission.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.permissions.update", [$permission->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('crud.permission.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" maxlength="191" name="title"
                           id="title" value="{{ old('title', $permission->title) }}" required>
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.permission.fields.title_helper') }}</span>
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