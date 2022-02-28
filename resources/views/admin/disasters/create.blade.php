@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.disaster.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.disasters.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.disaster.fields.school') }}</label>
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
                    <span class="help-block">{{ trans('crud.disaster.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="threats">{{ trans('crud.disaster.fields.threats') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('threats') ? 'is-invalid' : '' }}"
                            name="threats[]" id="threats" multiple required>
                        @foreach($threats as $id => $threat)
                            <option
                                value="{{ $id }}" {{ in_array($id, old('threats', [])) ? 'selected' : '' }}>{{ $threat }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('threats'))
                        <span class="text-danger">{{ $errors->first('threats') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.threats_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="potential">{{ trans('crud.disaster.fields.potential') }}</label>
                    <textarea class="form-control {{ $errors->has('potential') ? 'is-invalid' : '' }}" name="potential"
                              id="potential" required>{{ old('potential') }}</textarea>
                    @if($errors->has('potential'))
                        <span class="text-danger">{{ $errors->first('potential') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.potential_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="vulnerability">{{ trans('crud.disaster.fields.vulnerability') }}</label>
                    <textarea class="form-control {{ $errors->has('vulnerability') ? 'is-invalid' : '' }}"
                              name="vulnerability" id="vulnerability" required>{{ old('vulnerability') }}</textarea>
                    @if($errors->has('vulnerability'))
                        <span class="text-danger">{{ $errors->first('vulnerability') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.vulnerability_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="impact">{{ trans('crud.disaster.fields.impact') }}</label>
                    <textarea class="form-control {{ $errors->has('impact') ? 'is-invalid' : '' }}" name="impact"
                              id="impact" required>{{ old('impact') }}</textarea>
                    @if($errors->has('impact'))
                        <span class="text-danger">{{ $errors->first('impact') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.disaster.fields.impact_helper') }}</span>
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
