@extends('layouts.school')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.monitor.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route("school.monitors.update", ['school_slug' => $school_slug, $monitor->id]) }}"
                  id="formEdit">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.monitor.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#date" autocomplete="off"
                           name="date" id="date" value="{{ old('date', $monitor->date) }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.monitor.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="aspect_id">{{ trans('crud.workGroup.fields.aspect') }}</label>
                    <select class="form-control {{ $errors->has('aspect') ? 'is-invalid' : '' }}"
                            name="aspect_id" id="aspect_id" required>
                        @foreach($aspects as $id => $aspect)
                            <option
                                value="{{ $id }}" {{ old('aspect_id', $monitor->work_group->aspect_id) == $id ? 'selected' : '' }}>{{ $aspect }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('aspect'))
                        <span class="text-danger">{{ $errors->first('aspect') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.workGroup.fields.aspect_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="work_group_id">{{ trans('crud.monitor.fields.work_group') }}</label>
                    <select class="form-control select2 {{ $errors->has('work_group') ? 'is-invalid' : '' }}"
                            name="work_group_id" id="work_group_id" required>
                    </select>
                    @if($errors->has('work_group'))
                        <span class="text-danger">{{ $errors->first('work_group') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.monitor.fields.work_group_helper') }}</span>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Rencana Program (IPMLH)</th>
                                    <th>Kondisi Awal (Proker Kader)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(study, studyIndex) in studies" v-if="study.id !== ''">
                                    <td>@{{ studyIndex }}</td>
                                    <td v-html="study.activities"></td>
                                    <td>
                                        <ol style="padding-inline-start: 20px;">
                                            <li v-for="(workProgram, workProgramIndex) in study.study_work_programs">
                                                @{{ workProgram.condition }}
                                            </li>
                                        </ol>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hasil Pelaksanaan (Pelaksanaan Kegiatan)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(cadreActivity, cadreActivityIndex) in cadreActivities">
                                    <td>@{{ cadreActivityIndex+1 }}</td>
                                    <td>@{{ cadreActivity.results }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kendala (Pelaksanaan Kegiatan)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(cadreActivity, cadreActivityIndex) in cadreActivities">
                                    <td>@{{ cadreActivityIndex+1 }}</td>
                                    <td>@{{ cadreActivity.problem }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Rencana Tindak Lanjut (Pelaksanaan Kegiatan)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(cadreActivity, cadreActivityIndex) in cadreActivities">
                                    <td>@{{ cadreActivityIndex+1 }}</td>
                                    <td>@{{ cadreActivity.plan }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="team_statuses">{{ trans('crud.monitor.fields.team_status') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('team_statuses') ? 'is-invalid' : '' }}"
                            name="team_statuses[]" id="team_statuses" multiple required>
                        @foreach($teamStatuses as $id => $team_status)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('team_statuses', [])) || $monitor->team_statuses->contains($id)) ? 'selected' : '' }}>{{ $team_status }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team_statuses'))
                        <span class="text-danger">{{ $errors->first('team_statuses') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.monitor.fields.team_status_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="document">{{ trans('crud.monitor.fields.document') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                         id="document-dropzone">
                    </div>
                    @if($errors->has('document'))
                        <span class="text-danger">{{ $errors->first('document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.monitor.fields.document_helper') }}</span>

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
                studies: [],
                cadreActivities: [],
            },
            mounted: function () {

            },
            methods: {}
        })

        $ = jQuery;

        const formEdit = $('form#formEdit');

        $(function () {
            const selectAspectId = $('select#aspect_id');
            const selectWorkGroupId = $('select#work_group_id');

            selectAspectId.change(function () {
                if (selectAspectId.val()) {
                    let newOption;

                    selectWorkGroupId.attr('disabled');

                    axios.post('{{ route('api.work-groups') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        aspect: selectAspectId.val(),
                    })
                        .then(function (response) {
                            selectWorkGroupId.empty();

                            let workGroupIdVal = Number("{{ old('work_group_id', $monitor->work_group_id) }}");

                            response.data.forEach(function (data) {
                                newOption = new Option(data.text, data.id);
                                if (data.id === '') {
                                    newOption.setAttribute('selected', 'selected');
                                    newOption.setAttribute('disabled', 'disabled');
                                }
                                selectWorkGroupId.append(newOption);
                            });

                            selectWorkGroupId.removeAttr('disabled');

                            if (workGroupIdVal) {
                                selectWorkGroupId.val(('{{ old('work_group_id', $monitor->work_group_id) }}')).trigger('change');
                            }
                        })
                }
            });

            selectWorkGroupId.change(function () {
                if (selectWorkGroupId.val()) {

                    axios.post('{{ route('api.studies') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        work_group: selectWorkGroupId.val(),
                    })
                        .then(function (response) {
                            app.studies = response.data;
                        })

                    axios.post('{{ route('api.cadre-activities.data') }}', {
                        school: '{{ auth()->user()->isSTC }}',
                        work_group: selectWorkGroupId.val(),
                    })
                        .then(function (response) {
                            app.cadreActivities = response.data;
                        })
                }
            });

            selectAspectId.val(('{{ old('aspect_id', $monitor->work_group->aspect_id) }}')).trigger('change');
        });

        Dropzone.options.documentDropzone = {
            url: "{{ route('school.monitors.storeMedia', ['school_slug' => $school_slug]) }}",
            maxFilesize: 2, // MB
            acceptedFiles: '.pdf',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function (file, response) {
                const formEdit = $('form#formEdit');
                formEdit.find('input[name="document"]').remove();
                formEdit.append('<input type="hidden" name="document" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    $('form#formEdit').find('input[name="document"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($monitor) && $monitor->document)
                let file = {!! json_encode($monitor->document) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                $('form#formEdit').append('<input type="hidden" name="document" value="' + file.file_name + '">');
                this.options.maxFiles = this.options.maxFiles - 1;
                @endif
            },
            error: function (file, response) {
                let message;

                if ($.type(response) === 'string') {
                    message = response //dropzone sends it's own error messages in string
                } else {
                    message = response.errors.file
                }
                file.previewElement.classList.add('dz-error');
                let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
                let _results = [];
                for (let _i = 0, _len = _ref.length; _i < _len; _i++) {
                    let node = _ref[_i];
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection
