@extends('layouts.school')

@section('content')

    <div>
        <div class="card">
            <div class="card-header">
                {{ trans('global.create') }} {{ trans('crud.environment.title_singular') }}
            </div>

            <div class="card-body">
                <form method="POST"
                      action="{{ route("school.environments.store", ['school_slug' => $school_slug]) }}"
                      enctype="multipart/form-data" id="formCreate">
                    @csrf
                    <input type="hidden" name="year" value="{{ request()->input('year') }}" readonly>
                    <div>
                        <div class="form-group">
                            <label class="required"
                                   for="compiler">{{ trans('crud.environment.fields.compiler') }}</label>
                            <select class="form-control select2 {{ $errors->has('compiler') ? 'is-invalid' : '' }}"
                                    name="compiler" id="compiler"
                                {{ app()->environment() == 'production' ? 'required' : '' }}>
                            </select>
                            @if($errors->has('compiler'))
                                <span class="text-danger">{{ $errors->first('compiler') }}</span>
                            @endif
                            <span class="help-block">{{ trans('crud.environment.fields.compiler_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="isi">{{ trans('crud.environment.fields.isi') }}</label>
                            <textarea class="form-control {{ $errors->has('isi') ? 'is-invalid' : '' }}"
                                      name="isi" id="isi"
                                      maxlength="{{ \App\Environment::MAX_LENGTH_OF_ISI }}"
                            >{{ old('isi') }}</textarea>
                            @if($errors->has('isi'))
                                <span class="text-danger">{{ $errors->first('isi') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.isi_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="proses">{{ trans('crud.environment.fields.proses') }}</label>
                            <textarea class="form-control {{ $errors->has('proses') ? 'is-invalid' : '' }}"
                                      name="proses" id="proses"
                                      maxlength="100"
                            >{{ old('proses') }}</textarea>
                            @if($errors->has('proses'))
                                <span class="text-danger">{{ $errors->first('proses') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.proses_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="kompetensi_kelulusan">{{ trans('crud.environment.fields.kompetensi_kelulusan') }}</label>
                            <textarea class="form-control {{ $errors->has('kompetensi_kelulusan') ? 'is-invalid' : '' }}"
                                      name="kompetensi_kelulusan" id="kompetensi_kelulusan"
                                      maxlength="100"
                            >{{ old('kompetensi_kelulusan') }}</textarea>
                            @if($errors->has('kompetensi_kelulusan'))
                                <span class="text-danger">{{ $errors->first('kompetensi_kelulusan') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.kompetensi_kelulusan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="pendidik_dan_tenaga_kependidikan">{{ trans('crud.environment.fields.pendidik_dan_tenaga_kependidikan') }}</label>
                            <textarea class="form-control {{ $errors->has('pendidik_dan_tenaga_kependidikan') ? 'is-invalid' : '' }}"
                                      name="pendidik_dan_tenaga_kependidikan" id="pendidik_dan_tenaga_kependidikan"
                                      maxlength="100"
                            >{{ old('pendidik_dan_tenaga_kependidikan') }}</textarea>
                            @if($errors->has('pendidik_dan_tenaga_kependidikan'))
                                <span class="text-danger">{{ $errors->first('pendidik_dan_tenaga_kependidikan') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.pendidik_dan_tenaga_kependidikan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="sarana_prasarana">{{ trans('crud.environment.fields.sarana_prasarana') }}</label>
                            <textarea class="form-control {{ $errors->has('sarana_prasarana') ? 'is-invalid' : '' }}"
                                      name="sarana_prasarana" id="sarana_prasarana"
                                      maxlength="100"
                            >{{ old('sarana_prasarana') }}</textarea>
                            @if($errors->has('sarana_prasarana'))
                                <span class="text-danger">{{ $errors->first('sarana_prasarana') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.sarana_prasarana_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="pengelolaan">{{ trans('crud.environment.fields.pengelolaan') }}</label>
                            <textarea class="form-control {{ $errors->has('pengelolaan') ? 'is-invalid' : '' }}"
                                      name="pengelolaan" id="pengelolaan"
                                      maxlength="100"
                            >{{ old('pengelolaan') }}</textarea>
                            @if($errors->has('pengelolaan'))
                                <span class="text-danger">{{ $errors->first('pengelolaan') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.pengelolaan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="pembiayaan">{{ trans('crud.environment.fields.pembiayaan') }}</label>
                            <textarea class="form-control {{ $errors->has('pembiayaan') ? 'is-invalid' : '' }}"
                                      name="pembiayaan" id="pembiayaan"
                                      maxlength="100"
                            >{{ old('pembiayaan') }}</textarea>
                            @if($errors->has('pembiayaan'))
                                <span class="text-danger">{{ $errors->first('pembiayaan') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.pembiayaan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="penilaian_pendidikan">{{ trans('crud.environment.fields.penilaian_pendidikan') }}</label>
                            <textarea class="form-control {{ $errors->has('penilaian_pendidikan') ? 'is-invalid' : '' }}"
                                      name="penilaian_pendidikan" id="penilaian_pendidikan"
                                      maxlength="100"
                            >{{ old('penilaian_pendidikan') }}</textarea>
                            @if($errors->has('penilaian_pendidikan'))
                                <span class="text-danger">{{ $errors->first('penilaian_pendidikan') }}</span>
                            @endif
                            <span
                                class="help-block">{{ trans('crud.environment.fields.penilaian_pendidikan_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="file">
                                {{ trans('global.upload') }} {{ trans('crud.environment.fields.file') }}
                            </label>
                            <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                 id="file-dropzone">
                            </div>
                            @if($errors->has('file'))
                                <span class="text-danger">{{ $errors->first('file') }}</span>
                            @endif
                            <span class="help-block">{{ trans('crud.environment.fields.file_helper') }}</span>
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
    </div>
@endsection

@section('scripts')
    {{--<script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        const app = new Vue({
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
                        $ = jQuery;

                        if (app.has_document) {
                            $('textarea#isi').attr('required');
                            $('textarea#proses').attr('required');
                            $('textarea#kompetensi_kelulusan').attr('required');
                            $('textarea#pendidik_dan_tenaga_kependidikan').attr('required');
                            $('textarea#sarana_prasarana').attr('required');
                        } else {
                            $('textarea#isi').removeAttr('required');
                            $('textarea#proses').removeAttr('required');
                            $('textarea#kompetensi_kelulusan').removeAttr('required');
                            $('textarea#pendidik_dan_tenaga_kependidikan').removeAttr('required');
                            $('textarea#sarana_prasarana').removeAttr('required');
                        }
                    }, 1000);
                }
            }
        })
    </script>--}}
    <script>
        $ = jQuery;

        const formCreate = $('form#formCreate');

        Dropzone.options.documentDropzone = {
            url: '{{ route('school.environments.storeMedia', ['school_slug' => $school_slug]) }}',
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

        Dropzone.options.fileDropzone = {
            url: '{{ route('school.environments.storeMedia', ['school_slug' => $school_slug]) }}',
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
                formCreate.find('input[name="file"]').remove();
                formCreate.append('<input type="hidden" name="file" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="file"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($qualityReport) && $qualityReport->file)
                let file = {!! json_encode($qualityReport->file) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="file" value="' + file.file_name + '">');
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


        $(function () {
            const selectedCompiler = $('#compiler');

            axios.post('{{ route('api.teams') }}', {
                type: 'pembimbing',
                school_id: '{{ auth()->user()->isSTC }}'
            })
                .then(function (response) {
                    let selectedCompilerVal = "{!! old('compiler', '') !!}";
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
