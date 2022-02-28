@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.budgetPlan.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.budget-plans.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.budgetPlan.fields.school') }}</label>
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
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.budgetPlan.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}" name="aspect_id" id="aspect_id"
                            required>
                        <option value
                                disabled {{ old('aspect_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\BudgetPlan::TOPIC_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('aspect_id', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect_id'))
                        <span class="text-danger">{{ $errors->first('aspect_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="description">{{ trans('crud.budgetPlan.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description" id="description" required>{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="cost">{{ trans('crud.budgetPlan.fields.cost') }}</label>
                    <input class="form-control {{ $errors->has('cost') ? 'is-invalid' : '' }}" type="number" name="cost"
                           id="cost" value="{{ old('cost', '') }}" step="1" min="0" required>
                    @if($errors->has('cost'))
                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.cost_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="category">{{ trans('crud.budgetPlan.fields.category') }}</label>
                    <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category"
                            id="category" required>
                        <option value
                                disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($snp_categories as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('category', '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="source">{{ trans('crud.budgetPlan.fields.source') }}</label>
                    <select class="form-control {{ $errors->has('source') ? 'is-invalid' : '' }}" name="source"
                            id="source" required>
                        <option value
                                disabled {{ old('source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\BudgetPlan::SOURCE_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('source', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('source'))
                        <span class="text-danger">{{ $errors->first('source') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.source_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="pic">{{ trans('crud.budgetPlan.fields.pic') }}</label>
                    <input class="form-control {{ $errors->has('pic') ? 'is-invalid' : '' }}" type="text"
                           name="pic" id="pic" value="{{ old('pic', '') }}" required>
                    @if($errors->has('pic'))
                        <span class="text-danger">{{ $errors->first('pic') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.pic_helper') }}</span>
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
