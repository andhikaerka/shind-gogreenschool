@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.study.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.studies.update", ['school_slug' => $school_slug, $study->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required"
                           for="environment_id">{{ trans('crud.study.fields.environment_id') }}</label>
                    <select class="form-control select2 {{ $errors->has('environment') ? 'is-invalid' : '' }}"
                            name="environment_id" id="environment_id" required>
                        @foreach($environments as $id => $environment)
                            <option
                                value="{{ $id }}" {{ (old('environment_id', $study->environment->id ?? null)) == $id ? 'selected' : '' }}>{{ $environment }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('environment'))
                        <span class="text-danger">{{ $errors->first('environment') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.environment_id_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="self_development">{{ trans('crud.study.fields.self_development') }}</label>
                    <select class="form-control select2-tags {{ $errors->has('self_development') ? 'is-invalid' : '' }}" name="self_development"
                            id="self_development" required>
                        <option value
                                disabled {{ old('self_development', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Study::LIST_OF_SELF_DEVELOPMENT as $label)
                            <option
                                value="{{ $label }}" {{ old('self_development', $study->self_development) === (string) $label ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('self_development'))
                        <span class="text-danger">{{ $errors->first('self_development') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.self_development_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="environmental_issue_id">{{ trans('crud.lessonPlan.fields.environmental_issue_id') }}</label>
                    <select class="form-control select2 {{ $errors->has('environmental_issue_id') ? 'is-invalid' : '' }}" name="environmental_issue_id"
                            id="environmental_issue_id" required>
                        <option value disabled {{ old('environmental_issue_id', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        @foreach($environmentalIssues as $key => $environmentalIssue)
                            <option
                                value="{{ $key }}" {{ old('environmental_issue_id', $study->environmental_issue_id) === $key ? 'selected' : '' }}>
                                {{ $environmentalIssue }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('environmental_issue_id'))
                        <span class="text-danger">{{ $errors->first('environmental_issue_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.lessonPlan.fields.environmental_issue_id_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="aspect_id">{{ trans('crud.study.fields.aspect') }}</label>
                    <select class="form-control select2 {{ $errors->has('aspect_id') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', ($study->work_group->aspect_id ?? '')) == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect_id'))
                        <span class="text-danger">{{ $errors->first('aspect_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.aspect_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="work_group_id">Pilih Nama Pokja</label>
                    <select class="form-control select2 {{ $errors->has('work_group_id') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id"
                            {{ app()->environment() == 'production' ? 'required' : '' }} disabled="disabled">
                        <option value disabled {{ old('work_group_id', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}
                        </option>
                        {{--@foreach($workGroups as $id => $workGroup)
                            <option
                                value="{{ $id }}" {{ ($study->work_group ? $study->work_group->id : old('work_group_id')) == $id ? 'selected' : '' }}>{{ $workGroup }}</option>
                        @endforeach--}}
                    </select>
                    @if($errors->has('work_group_id'))
                        <span class="text-danger">{{ $errors->first('work_group_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.work_group_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="snp_category_id">{{ trans('crud.study.fields.snp_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('snp_category_id') ? 'is-invalid' : '' }}"
                            name="snp_category_id" id="snp_category_id"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                        @foreach($snpCategories as $id => $snpCategory)
                            <option
                                value="{{ $id }}" {{ old('snp_category_id', $study->snp_category_id) == $id ? 'selected' : '' }}>{{ $snpCategory }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('snp_category_id'))
                        <span class="text-danger">{{ $errors->first('snp_category_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.snp_category_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="potential">{{ trans('crud.study.fields.potential') }}</label>
                    <textarea class="form-control {{ $errors->has('potential') ? 'is-invalid' : '' }}" name="potential"
                              id="potential"
                              required>{{ old('potential', $study->potential) }}</textarea>
                    @if($errors->has('potential'))
                        <span class="text-danger">{{ $errors->first('potential') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.potential_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="problem">{{ trans('crud.study.fields.problem') }}</label>
                    <textarea class="form-control {{ $errors->has('problem') ? 'is-invalid' : '' }}" name="problem"
                              id="problem" maxlength="{{ \App\Study::MAX_LENGTH_OF_PROBLEM }}"
                              required>{{ old('problem', $study->problem) }}</textarea>
                    @if($errors->has('problem'))
                        <span class="text-danger">{{ $errors->first('problem') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.problem_helper') }}</span>
                </div>

                <div class="form-group" v-show="cts.length">
                    <label class="required" for="activity">{{ trans('crud.study.fields.activity') }}</label>
                    <ol type="1">
                        <li v-for="(ct, ctIndex) in cts">
                            <div v-if="ct.isParent === true">
                                <div>@{{ ct.name }}</div>
                                <div v-if="ct.selectAll === 1">
                                    <div v-for="(checklistTemplate, checklistTemplateIndex) in ct.checklistTemplates"
                                         class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                               :id="'inlineCheckbox'+checklistTemplate.id"
                                               :value="checklistTemplate.id" name="checklist_templates[]"
                                               :checked="checklist_templates.includes(String(checklistTemplate.id)) || checklist_templates.includes((checklistTemplate.id))"
                                        >
                                        <label class="form-check-label" :for="'inlineCheckbox'+checklistTemplate.id">
                                            @{{ checklistTemplate.text }}
                                        </label>
                                    </div>
                                </div>
                                <div v-else>
                                    <ol type="i">
                                        <li v-for="(checklistTemplate, checklistTemplateIndex) in ct.checklistTemplates">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       :id="'inlineCheckbox'+checklistTemplate.id"
                                                       :value="checklistTemplate.id" name="checklist_templates[]"
                                                       :checked="checklist_templates.includes(String(checklistTemplate.id)) || checklist_templates.includes((checklistTemplate.id))">
                                                <label class="form-check-label"
                                                       :for="'inlineCheckbox'+checklistTemplate.id">
                                                    @{{ checklistTemplate.text }}
                                                </label>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            <div v-else class="form-check">
                                <input class="form-check-input" type="checkbox" :value="ct.id"
                                       :id="'inlineCheckbox'+ct.id" name="checklist_templates[]"
                                       :checked="checklist_templates.includes(String(ct.id)) || checklist_templates.includes((ct.id))">
                                <label class="form-check-label" for="'inlineCheckbox'+ct.id">
                                    @{{ ct.text }}
                                </label>
                            </div>
                        </li>

                        <li>
                            <span class="help-block">Upaya lain ketik disini ...</span>
                            <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}"
                                      name="activity"
                                      id="activity" {{ app()->environment() == 'production' ? 'required' : '' }}>{{ old('activity', $study->activity) }}</textarea>
                            @if($errors->has('activity'))
                                <span class="text-danger">{{ $errors->first('activity') }}</span>
                            @endif
                            <span class="help-block">{{ trans('crud.study.fields.activity_helper') }}</span>
                        </li>
                    </ol>
                </div>

                <div class="form-group">
                    <label class="required" for="behavioral">{{ trans('crud.study.fields.behavioral') }}</label>
                    <textarea class="form-control {{ $errors->has('behavioral') ? 'is-invalid' : '' }}"
                              name="behavioral" id="behavioral" maxlength="{{ \App\Study::MAX_LENGTH_OF_BEHAVIORAL }}"
                              required>{{ old('behavioral', $study->behavioral) }}</textarea>
                    @if($errors->has('behavioral'))
                        <span class="text-danger">{{ $errors->first('behavioral') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.behavioral_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="physical">{{ trans('crud.study.fields.physical') }}</label>
                    <textarea class="form-control {{ $errors->has('physical') ? 'is-invalid' : '' }}" name="physical"
                              id="physical" maxlength="{{ \App\Study::MAX_LENGTH_OF_PHYSICAL }}"
                              required>{{ old('physical', $study->physical) }}</textarea>
                    @if($errors->has('physical'))
                        <span class="text-danger">{{ $errors->first('physical') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.physical_helper') }}</span>
                </div>{{--
                <div class="form-group">
                    <label class="required" for="kbm">{{ trans('crud.study.fields.kbm') }}</label>
                    <textarea class="form-control {{ $errors->has('kbm') ? 'is-invalid' : '' }}" name="kbm" id="kbm"
                              maxlength="{{ \App\Study::MAX_LENGTH_OF_KBM }}"
                              required>{{ old('kbm', $study->kbm) }}</textarea>
                    @if($errors->has('kbm'))
                        <span class="text-danger">{{ $errors->first('kbm') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.kbm_helper') }}</span>
                </div> --}}
                <div class="form-group">
                    <label class="required" for="artwork">{{ trans('crud.study.fields.artwork') }}</label>
                    <textarea class="form-control {{ $errors->has('artwork') ? 'is-invalid' : '' }}" name="artwork"
                              id="artwork" maxlength="{{ \App\Study::MAX_LENGTH_OF_ARTWORK }}"
                              required>{{ old('artwork', $study->artwork) }}</textarea>
                    @if($errors->has('artwork'))
                        <span class="text-danger">{{ $errors->first('artwork') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.artwork_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="period">{{ trans('crud.study.fields.period') }}</label>
                    <select class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" name="period"
                            id="period" required>
                        <option value
                                disabled {{ old('period', $study->period) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @for($period = \App\Study::MIN_PERIOD; $period <= \App\Study::MAX_PERIOD; $period++)
                            <option
                                value="{{ $period }}" {{ old('period', $study->period) == $period ? 'selected' : '' }}>
                                {{ $period }} Bulan
                            </option>
                        @endfor
                    </select>
                    @if($errors->has('period'))
                        <span class="text-danger">{{ $errors->first('period') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.period_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="lesson_plan_id">{{ trans('crud.study.fields.lesson_plan_id') }}</label>
                    <select class="form-control select2 {{ $errors->has('lesson_plan_id') ? 'is-invalid' : '' }}"
                            name="lesson_plan_id" id="lesson_plan_id"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('lesson_plan_id'))
                        <span class="text-danger">{{ $errors->first('lesson_plan_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.lesson_plan_id_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="budget_plan_id">{{ trans('crud.study.fields.budget_plan_id') }}</label>
                    <select class="form-control select2 {{ $errors->has('budget_plan_id') ? 'is-invalid' : '' }}"
                            name="budget_plan_id" id="budget_plan_id"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </select>
                    @if($errors->has('budget_plan_id'))
                        <span class="text-danger">{{ $errors->first('budget_plan_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.budget_plan_id_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="source">{{ trans('crud.study.fields.source') }}</label>
                    <select class="form-control select2-tags {{ $errors->has('source') ? 'is-invalid' : '' }}"
                            name="source"
                            id="source" required>
                        <option value
                                disabled {{ old('source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Study::SOURCE_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('source', $study->source) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                        @if(!in_array($study->source, App\Study::SOURCE_SELECT))
                            <option value="{{ $study->source }}" selected>{{ $study->source }}</option>
                        @endif
                    </select>
                    @if($errors->has('source'))
                        <span class="text-danger">{{ $errors->first('source') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.source_helper') }}</span>
                </div>{{--
                <div class="form-group">
                    <label class="required" for="cost">{{ trans('crud.study.fields.cost') }}</label>
                    <input class="form-control {{ $errors->has('cost') ? 'is-invalid' : '' }}" type="number" name="cost"
                           id="cost" value="{{ old('cost', $study->cost) }}" step="1" min="0" required>
                    @if($errors->has('cost'))
                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.cost_helper') }}</span>
                </div> --}}
                <div class="form-group">
                    <label class="required" for="partner_id">{{ trans('crud.study.fields.partner') }}</label>
                    <select class="form-control select2 {{ $errors->has('partner') ? 'is-invalid' : '' }}"
                            name="partner_id" id="partner_id" required>
                        @foreach($partners as $id => $partner)
                            <option
                                value="{{ $id }}" {{ ($study->partner ? $study->partner->id : old('partner_id')) == $id ? 'selected' : '' }}>{{ $partner }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('partner'))
                        <span class="text-danger">{{ $errors->first('partner') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.partner_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="percentage">{{ trans('crud.study.fields.percentage') }}</label>
                    <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number"
                           name="percentage"
                           id="percentage" value="{{ old('percentage', $study->percentage) }}" step="1"
                           min="{{ \App\Study::MIN_PERCENTAGE }}"
                           max="0" {{ app()->environment() == 'production' ? 'required' : '' }}>
                    @if($errors->has('percentage'))
                        <span class="text-danger">{{ $errors->first('percentage') }}</span>
                    @endif
                    <span id="percentage-status" class="help-block text-danger"></span>
                </div>

                <div class="form-group">
                    <label class="required" for="team_statuses">{{ trans('crud.study.fields.team_statuses') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('team_statuses') ? 'is-invalid' : '' }}"
                            name="team_statuses[]" id="team_statuses"
                            multiple {{ app()->environment() == 'production' ? 'required' : '' }}>
                        @foreach($teamStatuses as $id => $team_status)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('team_statuses', [])) || $study->team_statuses->contains($id)) ? 'selected' : '' }}>{{ $team_status }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team_statuses'))
                        <span class="text-danger">{{ $errors->first('team_statuses') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.study.fields.team_statuses_helper') }}</span>
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
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        const app = new Vue({
            el: '#app',
            data: {
                cts: [],
                checklist_templates: {!! json_encode(old('checklist_templates', $study->checklist_templates()->pluck('id')->toArray())) !!}
            },
            mounted: function () {

            },
            methods: {}
        })

        $ = jQuery;

        $(function () {
            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');
            const percentage = $('#percentage');
            const percentageStatus = $('#percentage-status');
            const selectedBudgetPlan = $('#budget_plan_id');
            const selectedLessonPlan = $('#lesson_plan_id');
            const oldAspect = {{ $study->work_group->aspect_id }};
            const oldPercentage = {{ $study->percentage }};

            let newOption;

            selectAspectId.change(function () {
                axios.post('{{ route('api.work-groups') }}', {
                    school: '{{ auth()->user()->isSTC }}',
                    aspect: selectAspectId.val(),
                    year: {{ $study->work_group->school_profile->year }}
                })
                    .then(function (response) {
                        selectWorkGroupId.empty();

                        let workGroupIdVal = Number("{{ old('work_group_id', $study->work_group_id) }}");

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

                axios.post('{{ route('api.checklist-templates') }}', {
                    aspect: selectAspectId.val(),
                })
                    .then(function (response) {
                        app.cts = response.data;
                    })

                axios.post('{{ route('api.studies.check-percentage') }}', {
                    school_slug: '{{ $school_slug }}',
                    aspect_id: selectAspectId.val(),
                    year: {{ $study->work_group->school_profile->year }}
                })
                    .then(function (response) {
                        let maxPercentage = 0;
                        if(selectAspectId.val() == oldAspect){
                            maxPercentage = response.data.maxPercentage + oldPercentage;
                        }else{
                            maxPercentage = response.data.maxPercentage;
                        }
                        percentage.attr('max', maxPercentage)
                        maxPercentage == 0 ?
                        percentageStatus.text('sudah terpenuhi 100%') :
                        percentageStatus.text('maksimal '+maxPercentage+'%')
                    });

                 axios.post('{{ route('api.lesson-plans') }}', {
                    aspect_id: selectAspectId.val(),
                    school_slug: '{{ $school_slug }}',
                    year: {{ $study->work_group->school_profile->year }}
                })
                    .then(function (response) {
                        let selectedLessonPlanVal = "{!! old('lesson_plan_id', $study->lesson_plan_id) !!}";
                        selectedLessonPlan.empty();
                        response.data.forEach(function (data) {
                            newOption = new Option(data.text, data.id);
                            if (data.id === '') {
                                newOption.setAttribute('selected', 'selected');
                                newOption.setAttribute('disabled', 'disabled');
                            }
                            selectedLessonPlan.append(newOption);
                        });

                        selectedLessonPlan.removeAttr('disabled');

                        if(selectedLessonPlanVal){
                            selectedLessonPlan.val(selectedLessonPlanVal).trigger('change');
                        }
                    })

                axios.post('{{ route('api.budget-plans') }}', {
                    aspect_id: selectAspectId.val(),
                    school_slug: '{{ $school_slug }}',
                    year: {{ $study->work_group->school_profile->year }}
                })
                    .then(function (response) {
                        let selectedBudgetPlanVal = "{!! old('budget_plan_id', $study->budget_plan_id) !!}";
                        selectedBudgetPlan.empty();
                        response.data.forEach(function (data) {
                            newOption = new Option(data.text, data.id);
                            if (data.id === '') {
                                newOption.setAttribute('selected', 'selected');
                                newOption.setAttribute('disabled', 'disabled');
                            }
                            selectedBudgetPlan.append(newOption);
                        });

                        selectedBudgetPlan.removeAttr('disabled');

                        if(selectedBudgetPlanVal){
                            selectedBudgetPlan.val(selectedBudgetPlanVal).trigger('change');
                        }
                    })
            });

            selectAspectId.val(Number('{{ old('aspect_id', $study->work_group->aspect_id) }}')).trigger('change');
        });
    </script>
@endsection
