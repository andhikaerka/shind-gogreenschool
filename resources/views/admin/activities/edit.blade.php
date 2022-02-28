@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.activity.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.activities.update", [$activity->id]) }}" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.qualityReport.fields.school') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}"
                            name="school_id" id="school_id" required>
                        @foreach($schools as $id => $school)
                            <option
                                value="{{ $id }}" {{ $id == old('school_id', $activity->work_group->school_id) ? 'selected' : '' }}>
                                {{ $school }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('school'))
                        <span class="text-danger">{{ $errors->first('school') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.qualityReport.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.activity.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#date"
                           name="date" id="date" value="{{ old('date', $activity->date) }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="work_group_id">{{ trans('crud.activity.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id" required>
                        @foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ ($activity->work_group ? $activity->work_group->id : old('work_group_id')) == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.work_group_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="potential">{{ trans('crud.activity.fields.potential') }}</label>
                    <textarea class="form-control {{ $errors->has('potential') ? 'is-invalid' : '' }}" name="potential"
                              id="potential" required>{{ old('potential', $activity->potential) }}</textarea>
                    @if($errors->has('potential'))
                        <span class="text-danger">{{ $errors->first('potential') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.potential_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="problem">{{ trans('crud.activity.fields.problem') }}</label>
                    <textarea class="form-control {{ $errors->has('problem') ? 'is-invalid' : '' }}" name="problem"
                              id="problem" required>{{ old('problem', $activity->problem) }}</textarea>
                    @if($errors->has('problem'))
                        <span class="text-danger">{{ $errors->first('problem') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.problem_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="activity">{{ trans('crud.activity.fields.activity') }}</label>
                    <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity"
                              id="activity" required>{{ old('activity', $activity->activity) }}</textarea>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.activity_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="behavioral">{{ trans('crud.activity.fields.behavioral') }}</label>
                    <textarea class="form-control {{ $errors->has('behavioral') ? 'is-invalid' : '' }}"
                              name="behavioral" id="behavioral"
                              required>{{ old('behavioral', $activity->behavioral) }}</textarea>
                    @if($errors->has('behavioral'))
                        <span class="text-danger">{{ $errors->first('behavioral') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.behavioral_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="physical">{{ trans('crud.activity.fields.physical') }}</label>
                    <textarea class="form-control {{ $errors->has('physical') ? 'is-invalid' : '' }}" name="physical"
                              id="physical" required>{{ old('physical', $activity->physical) }}</textarea>
                    @if($errors->has('physical'))
                        <span class="text-danger">{{ $errors->first('physical') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.physical_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="cost">{{ trans('crud.activity.fields.cost') }}</label>
                    <input class="form-control {{ $errors->has('cost') ? 'is-invalid' : '' }}" type="number" name="cost"
                           id="cost" value="{{ old('cost', $activity->cost) }}" step="1" min="0" required>
                    @if($errors->has('cost'))
                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.cost_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="partner_id">{{ trans('crud.activity.fields.partner') }}</label>
                    <select class="form-control select2 {{ $errors->has('partner') ? 'is-invalid' : '' }}"
                            name="partner_id" id="partner_id" required>
                        @foreach($partners as $id => $partner)
                            <option
                                value="{{ $id }}" {{ ($activity->partner ? $activity->partner->id : old('partner_id')) == $id ? 'selected' : '' }}>{{ $partner }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('partner'))
                        <span class="text-danger">{{ $errors->first('partner') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.activity.fields.partner_helper') }}</span>
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
        $(function () {
            const selectSchoolId = $('select#school_id');
            const selectWorkGroupId = $('select#work_group_id');
            const selectPartnerId = $('select#partner_id');

            selectSchoolId.change(function () {
                setTimeout(function () {
                    let newOption;

                    axios.post('{{ route('api.work-groups') }}', {
                        school: selectSchoolId.val(),
                    })
                        .then(function (response) {
                            selectWorkGroupId.empty();

                            let workGroupIdVal = Number("{{ old('work_group_id', $activity->work_group_id ?? null) }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === workGroupIdVal), (data.id === workGroupIdVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkGroupId.append(newOption);
                            });

                            selectWorkGroupId.removeAttr('disabled');
                        });
                }, 500);

                setTimeout(function () {
                    let newOption;

                    axios.post('{{ route('api.partners') }}', {
                        school: selectSchoolId.val(),
                    })
                        .then(function (response) {
                            selectPartnerId.empty();

                            let partnerIdVal = Number("{{ old('partner_id', $activity->partner_id ?? null) }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id, (data.id === partnerIdVal), (data.id === partnerIdVal));
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectPartnerId.append(newOption);
                            });

                            selectPartnerId.removeAttr('disabled');
                        })
                }, 599)
            });

            selectSchoolId.val(Number('{{ old('school_id', $activity->work_group->school_id ?? null) }}')).trigger('change');
        });
    </script>
@endsection
