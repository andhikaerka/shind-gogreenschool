@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.budgetPlan.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.budget-plans.update", ['school_slug' => $school_slug, $budgetPlan->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.budgetPlan.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}" name="aspect_id"
                            id="aspect_id"
                            required>
                        <option value
                                disabled {{ old('aspect_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($aspects as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('aspect_id', $budgetPlan->aspect_id) == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                              name="description" id="description"
                              required>{{ old('description', $budgetPlan->description) }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="cost">{{ trans('crud.budgetPlan.fields.cost') }}</label>
                    <input class="form-control {{ $errors->has('cost') ? 'is-invalid' : '' }}" type="number" name="cost"
                           id="cost" value="{{ old('cost', $budgetPlan->cost) }}" step="1" min="0" required>
                    @if($errors->has('cost'))
                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.cost_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="snp_category_id">{{ trans('crud.budgetPlan.fields.snp_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('snp_category_id') ? 'is-invalid' : '' }}"
                            name="snp_category_id" id="snp_category_id"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        @foreach($snpCategories as $id => $snpCategory)
                            <option
                                value="{{ $id }}" {{ old('snp_category_id', $budgetPlan->snp_category_id) == $id ? 'selected' : '' }}>{{ $snpCategory }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('snp_category_id'))
                        <span class="text-danger">{{ $errors->first('snp_category_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.snp_category_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="source">{{ trans('crud.budgetPlan.fields.source') }}</label>
                    <select class="form-control select2-tags {{ $errors->has('source') ? 'is-invalid' : '' }}"
                            name="source"
                            id="source" required>
                        <option value
                                disabled {{ old('source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\BudgetPlan::SOURCE_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('source', $budgetPlan->source) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                        @if(!in_array($budgetPlan->source, App\BudgetPlan::SOURCE_SELECT))
                            <option value="{{ $budgetPlan->source }}" selected>{{ $budgetPlan->source }}</option>
                        @endif
                    </select>
                    @if($errors->has('source'))
                        <span class="text-danger">{{ $errors->first('source') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.budgetPlan.fields.source_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="pic">{{ trans('crud.budgetPlan.fields.pic') }}</label>
                    <select class="form-control select2 {{ $errors->has('pic') ? 'is-invalid' : '' }}"
                            name="pic" id="pic"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
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

@section('scripts')
<script>
    const pic = $('#pic');
    axios.post('{{ route('api.teams') }}', {
        type: 'bendahara',
        school_id: '{{ auth()->user()->isSTC }}'
    })
        .then(function (response) {
            pic.empty();
            let picVal = "{!! old('pic', $budgetPlan->pic) !!}";
            response.data.forEach(function (data) {
                newOption = new Option(data.text, data.text);
                if (data.id === '') {
                    newOption.setAttribute('selected', 'selected');
                    newOption.setAttribute('disabled', 'disabled');
                }
                pic.append(newOption);
            });

            pic.removeAttr('disabled');

            if (picVal) {
                pic.val(picVal).trigger('change');
            }
        })
</script>
@endsection
