@extends('layouts.school')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.activityImplementation.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.activity-implementations.update", ['school_slug' => $school_slug, $activityImplementation->id]) }}" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.activityImplementation.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}"
                           type="text" data-toggle="datetimepicker" data-target="#date" autocomplete="off"
                           name="date" id="date" value="{{ old('date', $activityImplementation->date) }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.activityImplementation.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            required {{ !(auth()->user()->isSTC ?? false) ? 'disabled' : '' }}>
                        @foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ old('work_group_id', $activityImplementation->work_group_id) == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="activity_id">{{ trans('crud.activityImplementation.fields.activity') }}</label>
                    <select class="form-control select2 {{ $errors->has('activity') ? 'is-invalid' : '' }}"
                            name="activity_id" id="activity_id"
                            required {{ !(auth()->user()->isSTC ?? false) ? 'disabled' : '' }}>
                        @foreach($activities as $id => $activity)
                            <option
                                value="{{ $id }}" {{ old('activity_id', $activityImplementation->activity_id) == $id ? 'selected' : '' }}>{{ $activity }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.activity_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="progress">{{ trans('crud.activityImplementation.fields.progress') }}</label>
                    <select class="form-control {{ $errors->has('progress') ? 'is-invalid' : '' }}" name="progress"
                            id="progress"
                            required>
                        <option value
                                disabled {{ old('progress', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\ActivityImplementation::PROGRESS_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('progress', $activityImplementation->progress) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('progress'))
                        <span class="text-danger">{{ $errors->first('progress') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.progress_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="constraints">{{ trans('crud.activityImplementation.fields.constraints') }}</label>
                    <textarea class="form-control {{ $errors->has('constraints') ? 'is-invalid' : '' }}"
                              name="constraints"
                              id="constraints" required>{{ old('constraints', $activityImplementation->constraints) }}</textarea>
                    @if($errors->has('constraints'))
                        <span class="text-danger">{{ $errors->first('constraints') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.constraints_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="plan">{{ trans('crud.activityImplementation.fields.plan') }}</label>
                    <textarea class="form-control {{ $errors->has('plan') ? 'is-invalid' : '' }}" name="plan"
                              id="plan" required>{{ old('plan', $activityImplementation->plan) }}</textarea>
                    @if($errors->has('plan'))
                        <span class="text-danger">{{ $errors->first('plan') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.plan_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="document">{{ trans('crud.activityImplementation.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activityImplementation.fields.document_helper') }}</span>
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

@endsection
