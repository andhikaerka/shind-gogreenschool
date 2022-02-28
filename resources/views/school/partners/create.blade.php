@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('crud.partner.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("school.partners.store", ['school_slug' => $school_slug]) }}"
                  enctype="multipart/form-data"
                  id="formCreate">
                @csrf
                <input type="hidden" name="year" value="{{ request()->input('year') }}" readonly>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.partner.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                           maxlength="{{ \App\Partner::MAX_LENGTH_OF_NAME }}" name="name"
                           id="name"
                           value="{{ old('name', '') }}" {{ app()->environment() == 'production' ? 'required' : '' }}>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="cp_name">{{ trans('crud.partner.fields.cp_name') }}</label>

                    <div class="input-group">
                        <input class="form-control {{ $errors->has('cp_name') ? 'is-invalid' : '' }}" type="text"
                               maxlength="{{ \App\Partner::MAX_LENGTH_OF_CP_NAME }}" name="cp_name"
                               placeholder="Nama"
                               id="cp_name"
                               value="{{ old('cp_name', '') }}" {{ app()->environment() == 'production' ? 'required' : '' }}>
                        <input class="form-control {{ $errors->has('cp_phone') ? 'is-invalid' : '' }}" type="text"
                               name="cp_phone"
                               id="cp_phone" value="{{ old('cp_phone', '') }}" title="No HP" placeholder="No HP"
                               data-inputmask="'mask': ['9{10,20}'], 'placeholder': ''"
                               data-mask {{ app()->environment() == 'production' ? 'required' : '' }}>
                    </div>

                    @if($errors->has('cp_name') || $errors->has('cp_phone'))
                        <span
                            class="text-danger">{{ $errors->has('cp_name') ? $errors->first('cp_name') : $errors->first('cp_phone') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.cp_name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="partner_category_id">{{ trans('crud.partner.fields.partner_category') }}</label>
                    <select class="form-control {{ $errors->has('partner_category_id') ? 'is-invalid' : '' }}"
                            name="partner_category_id"
                            id="partner_category_id" {{ app()->environment() == 'production' ? 'required' : '' }}>
                        <option value
                                disabled {{ old('partner_category_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($partner_categories as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('partner_category_id', '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('partner_category_id'))
                        <span class="text-danger">{{ $errors->first('partner_category_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.partner_category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="partner_activity_id">{{ trans('crud.partner.fields.partner_activity') }}</label>
                    <select class="form-control select2-tags {{ $errors->has('partner_activity_id') ? 'is-invalid' : '' }}"
                            name="partner_activity_id"
                            id="partner_activity_id" {{ app()->environment() == 'production' ? 'required' : '' }}>
                        <option value
                                disabled {{ old('partner_activity_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($partner_activities as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('partner_activity_id', '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('partner_activity_id'))
                        <span class="text-danger">{{ $errors->first('partner_activity_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.partner_activity_helper') }}</span>
                </div>
                {{--<div class="form-group">
                    <label class="required" for="activity">{{ trans('crud.partner.fields.activity') }}</label>
                    <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity"
                              id="activity" {{ app()->environment() == 'production' ? 'required' : '' }}>{{ old('activity') }}</textarea>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.activity_helper') }}</span>
                </div>--}}
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.partner.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#date" autocomplete="off"
                           name="date" id="date"
                           value="{{ old('date') }}" {{ app()->environment() == 'production' ? 'required' : '' }}>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="purpose">{{ trans('crud.partner.fields.purpose') }}</label>
                    <textarea class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose"
                              id="purpose" maxlength="{{ \App\Partner::MAX_LENGTH_OF_PURPOSE }}"
                              {{ app()->environment() == 'production' ? 'required' : '' }}>{{ old('purpose') }}</textarea>
                    @if($errors->has('purpose'))
                        <span class="text-danger">{{ $errors->first('purpose') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.purpose_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="total_people">{{ trans('crud.partner.fields.total_people') }}</label>
                    <input class="form-control {{ $errors->has('total_people') ? 'is-invalid' : '' }}" type="number"
                           min="1"
                           name="total_people" id="total_people" value="{{ old('total_people', '') }}" step="1"
                        {{ app()->environment() == 'production' ? 'required' : '' }}>
                    @if($errors->has('total_people'))
                        <span class="text-danger">{{ $errors->first('total_people') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.total_people_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="photo">{{ trans('crud.partner.fields.photo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}"
                         id="photo-dropzone">
                    </div>
                    @if($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.photo_helper') }}</span>
                </div>

                <div class="form-group">
                    <input type="hidden" name="add_more" id="add_more" value="{{ old('add_more', 0) }}">
                    <button class="btn btn-warning" type="button" onclick="$('#add_more').val(1); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.add') }} {{ trans('crud.partner.title_singular') }}?
                    </button>
                    <button class="btn btn-danger" type="button" onclick="$('#add_more').val(0); setTimeout(function() {
                      $('#formCreate').submit();
                    }, 300)">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        const formCreate = $('form#formCreate');

        Dropzone.options.photoDropzone = {
            url: '{{ route('school.partners.storeMedia', ['school_slug' => $school_slug]) }}',
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
                formCreate.find('input[name="photo"]').remove();
                formCreate.append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formCreate.find('input[name="photo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($partner) && $partner->photo)
                let file = {!! json_encode($partner->photo) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formCreate.append('<input type="hidden" name="photo" value="' + file.file_name + '">');
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
