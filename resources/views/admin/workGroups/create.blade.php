@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.workGroup.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.work-groups.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.workGroup.fields.school') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}"
                            name="school_id" id="school_id" required>
                        @foreach($schools as $id => $school)
                            <option
                                value="{{ $id }}" {{ old('school_id') == $id ? 'selected' : '' }}>{{ $school }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('school'))
                        <span class="text-danger">{{ $errors->first('school') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="year">{{ trans('crud.schoolProfile.fields.year') }}</label>
                    <input class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" type="text" name="year"
                           id="year" value="{{ old('year', date('Y')) }}"
                           minlength="4" maxlength="4"
                           data-inputmask="'mask': ['9999'], 'placeholder': ''"
                           data-mask required>
                    @if($errors->has('year'))
                        <span class="text-danger">{{ $errors->first('year') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.schoolProfile.fields.year_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.workGroup.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" maxlength="191"
                           name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="tutor_1">{{ trans('crud.workGroup.fields.tutor_1') }}</label>
                    <input class="form-control {{ $errors->has('tutor_1') ? 'is-invalid' : '' }}" type="text"
                           name="tutor_1" id="tutor_1" value="{{ old('tutor_1', '') }}" required>
                    @if($errors->has('tutor_1'))
                        <span class="text-danger">{{ $errors->first('tutor_1') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.tutor_1_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="tutor_2">{{ trans('crud.workGroup.fields.tutor_2') }}</label>
                    <input class="form-control {{ $errors->has('tutor_2') ? 'is-invalid' : '' }}" type="text"
                           name="tutor_2" id="tutor_2" value="{{ old('tutor_2', '') }}" required>
                    @if($errors->has('tutor_2'))
                        <span class="text-danger">{{ $errors->first('tutor_2') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.tutor_2_helper') }}</span>
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
