@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.workGroup.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.work-groups.update", ['school_slug' => $school_slug, $workGroup->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                {{--<div class="form-group">
                    <label class="required" for="year">{{ trans('crud.schoolProfile.fields.year') }}</label>
                    <input class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" type="text" name="year"
                           id="year" value="{{ old('year', $workGroup->year) }}"
                           minlength="4" maxlength="4"
                           data-inputmask="'mask': ['9999'], 'placeholder': ''"
                           data-mask required>
                    @if($errors->has('year'))
                        <span class="text-danger">{{ $errors->first('year') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.schoolProfile.fields.year_helper') }}</span>
                </div>--}}
                <div class="form-group">
                    <label class="required"
                           for="work_group_name_id">{{ trans('crud.workGroup.fields.work_group_name') }}</label>
                    <input type="hidden" name="name" id="name" value="{{ old('name', $workGroup->alias) }}">
                    <select class="form-control select2 {{ $errors->has('work_group_name_id') ? 'is-invalid' : '' }}"
                            name="work_group_name_id" id="work_group_name_id" required>
                        @foreach($workGroupNames as $id => $workGroupName)
                            <option
                                value="{{ $id }}" {{ old('work_group_name_id', $workGroup->work_group_name_id) == $id ? 'selected' : '' }}>{{ $workGroupName }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('work_group_name_id'))
                        <span class="text-danger">{{ $errors->first('work_group_name_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.work_group_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="description">{{ trans('crud.workGroup.fields.description') }}</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" maxlength="191"
                           name="description" id="description" value="{{ old('description', $workGroup->description ?? '') }}" required>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.workGroup.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id" required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', $workGroup->aspect_id) == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect_id'))
                        <span class="text-danger">{{ $errors->first('aspect_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.aspect_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="tutor">{{ trans('crud.extracurricular.fields.tutor') }}</label>
                    <select class="form-control select2-tags {{ $errors->has('tutor') ? 'is-invalid' : '' }}"
                            name="tutor" id="tutor"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('tutor'))
                        <span class="text-danger">{{ $errors->first('tutor') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.extracurricular.fields.tutor_helper') }}</span>
                </div>
                {{--<div class="form-group">
                    <label class="required" for="tutor_1">{{ trans('crud.workGroup.fields.tutor_1') }}</label>
                    <input class="form-control {{ $errors->has('tutor_1') ? 'is-invalid' : '' }}" type="text"
                           name="tutor_1" id="tutor_1" value="{{ old('tutor_1', $workGroup->tutor_1) }}" required>
                    @if($errors->has('tutor_1'))
                        <span class="text-danger">{{ $errors->first('tutor_1') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.tutor_1_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="tutor_2">{{ trans('crud.workGroup.fields.tutor_2') }}</label>
                    <input class="form-control {{ $errors->has('tutor_2') ? 'is-invalid' : '' }}" type="text"
                           name="tutor_2" id="tutor_2" value="{{ old('tutor_2', $workGroup->tutor_2) }}" required>
                    @if($errors->has('tutor_2'))
                        <span class="text-danger">{{ $errors->first('tutor_2') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.tutor_2_helper') }}</span>
                </div>--}}
                <div class="form-group">
                    <label class="required" for="task">{{ trans('crud.workGroup.fields.task') }}</label>
                    <textarea name="task" id="task" class="form-control {{ $errors->has('task') ? 'is-invalid' : '' }}"
                              maxlength="{{ \App\WorkGroup::MAX_LENGTH_OF_TASK }}"
                              required>{{ old('task', $workGroup->task) }}</textarea>
                    @if($errors->has('task'))
                        <span class="text-danger">{{ $errors->first('task') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.task_helper') }}</span>
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
        $ = jQuery;

        $(function () {
            $('#work_group_name_id').change(function () {
                $('#name').val($('#work_group_name_id option:selected').text());
            })
        })

        $(function () {
            const selectedCompiler = $('#tutor');

            axios.post('{{ route('api.teams') }}', {
                type: 'pembimbing',
                school_id: '{{ auth()->user()->isSTC }}'
            })
                .then(function (response) {
                    let selectedCompilerVal = "{!! old('tutor', $workGroup->tutor) !!}";
                    selectedCompiler.empty();
                    response.data.forEach(function (data) {
                        newOption = new Option(data.text, data.text);
                        if (data.id === '') {
                            newOption.setAttribute('selected', 'selected');
                            newOption.setAttribute('disabled', 'disabled');
                        }
                        selectedCompiler.append(newOption);
                    });

                    selectedCompiler.removeAttr('disabled');

                    if(selectedCompilerVal){
                        selectedCompiler.val(selectedCompilerVal).trigger('change');
                        console.log(1)
                    }
                        console.log(2)
                })
        });
    </script>
@endsection

