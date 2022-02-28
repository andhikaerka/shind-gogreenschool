@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.qualityReport.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.quality-reports.store") }}" enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.qualityReport.fields.school') }}</label>
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
                    <span class="help-block">{{ trans('crud.qualityReport.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('has_document') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="checkbox" name="has_document" id="has_document" value="1"
                               {{ old('has_document', 0) == 1 ? 'checked' : '' }} v-model="has_document"
                               @change="inputOnChange">
                        <label class="required form-check-label"
                               for="has_document">{{ trans('crud.qualityReport.fields.has_document') }}</label>
                    </div>
                    @if($errors->has('has_document'))
                        <span class="text-danger">{{ $errors->first('has_document') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.qualityReport.fields.has_document_helper') }}</span>
                </div>
                <div v-show="has_document === true">
                    <div class="form-group">
                        <label class="required" for="document">{{ trans('crud.qualityReport.fields.document') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('document') ? 'is-invalid' : '' }}"
                             id="document-dropzone">
                        </div>
                        @if($errors->has('document'))
                            <span class="text-danger">{{ $errors->first('document') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.qualityReport.fields.document_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required"
                               for="waste_management">{{ trans('crud.qualityReport.fields.waste_management') }}</label>
                        <textarea class="form-control {{ $errors->has('waste_management') ? 'is-invalid' : '' }}"
                                  name="waste_management" id="waste_management"
                        >{{ old('waste_management') }}</textarea>
                        @if($errors->has('waste_management'))
                            <span class="text-danger">{{ $errors->first('waste_management') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.qualityReport.fields.waste_management_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required"
                               for="energy_conservation">{{ trans('crud.qualityReport.fields.energy_conservation') }}</label>
                        <textarea class="form-control {{ $errors->has('energy_conservation') ? 'is-invalid' : '' }}"
                                  name="energy_conservation" id="energy_conservation"
                        >{{ old('energy_conservation') }}</textarea>
                        @if($errors->has('energy_conservation'))
                            <span class="text-danger">{{ $errors->first('energy_conservation') }}</span>
                        @endif
                        <span
                            class="help-block">{{ trans('crud.qualityReport.fields.energy_conservation_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required"
                               for="life_preservation">{{ trans('crud.qualityReport.fields.life_preservation') }}</label>
                        <textarea class="form-control {{ $errors->has('life_preservation') ? 'is-invalid' : '' }}"
                                  name="life_preservation" id="life_preservation"
                        >{{ old('life_preservation') }}</textarea>
                        @if($errors->has('life_preservation'))
                            <span class="text-danger">{{ $errors->first('life_preservation') }}</span>
                        @endif
                        <span
                            class="help-block">{{ trans('crud.qualityReport.fields.life_preservation_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required"
                               for="water_conservation">{{ trans('crud.qualityReport.fields.water_conservation') }}</label>
                        <textarea class="form-control {{ $errors->has('water_conservation') ? 'is-invalid' : '' }}"
                                  name="water_conservation" id="water_conservation"
                        >{{ old('water_conservation') }}</textarea>
                        @if($errors->has('water_conservation'))
                            <span class="text-danger">{{ $errors->first('water_conservation') }}</span>
                        @endif
                        <span
                            class="help-block">{{ trans('crud.qualityReport.fields.water_conservation_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required"
                               for="canteen_management">{{ trans('crud.qualityReport.fields.canteen_management') }}</label>
                        <textarea class="form-control {{ $errors->has('canteen_management') ? 'is-invalid' : '' }}"
                                  name="canteen_management" id="canteen_management"
                        >{{ old('canteen_management') }}</textarea>
                        @if($errors->has('canteen_management'))
                            <span class="text-danger">{{ $errors->first('canteen_management') }}</span>
                        @endif
                        <span
                            class="help-block">{{ trans('crud.qualityReport.fields.canteen_management_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="letter">{{ trans('crud.qualityReport.fields.letter') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('letter') ? 'is-invalid' : '' }}"
                             id="letter-dropzone">
                        </div>
                        @if($errors->has('letter'))
                            <span class="text-danger">{{ $errors->first('letter') }}</span>
                        @endif
                        <span class="help-block">{{ trans('crud.qualityReport.fields.letter_helper') }}</span>
                    </div>
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
        app = new Vue({
            el: '#app',
            data: {
                has_document: '{{ old('has_document') }}'
            },
            mounted: function () {
                this.inputOnChange();
            },
            methods: {
                inputOnChange() {
                    setTimeout(function () {
                        if (app.has_document) {
                            $('textarea#waste_management').attr('required');
                            $('textarea#energy_conservation').attr('required');
                            $('textarea#life_preservation').attr('required');
                            $('textarea#water_conservation').attr('required');
                            $('textarea#canteen_management').attr('required');
                        } else {
                            $('textarea#waste_management').removeAttr('required');
                            $('textarea#energy_conservation').removeAttr('required');
                            $('textarea#life_preservation').removeAttr('required');
                            $('textarea#water_conservation').removeAttr('required');
                            $('textarea#canteen_management').removeAttr('required');
                        }
                    }, 1000);
                }
            }
        })
    </script>
    <script>
        const formCreate = $('form#formCreate');

        Dropzone.options.documentDropzone = {
            url: '{{ route('admin.quality-reports.storeMedia') }}',
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
                formCreate.find('input[name="document"]').remove();
                formCreate.append('<input type="hidden" name="document" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="document"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($qualityReport) && $qualityReport->document)
                let file = {!! json_encode($qualityReport->document) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="document" value="' + file.file_name + '">');
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
        };

        Dropzone.options.letterDropzone = {
            url: '{{ route('admin.quality-reports.storeMedia') }}',
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
                formCreate.find('input[name="letter"]').remove();
                formCreate.append('<input type="hidden" name="letter" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="letter"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($qualityReport) && $qualityReport->letter)
                let file = {!! json_encode($qualityReport->letter) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="letter" value="' + file.file_name + '">');
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
