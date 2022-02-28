@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('crud.partner.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.partners.update", [$partner->id]) }}"
                  enctype="multipart/form-data" id="formEdit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="school_id">{{ trans('crud.partner.fields.school') }}</label>
                    <select class="form-control select2 {{ $errors->has('school') ? 'is-invalid' : '' }}"
                            name="school_id" id="school_id" required>
                        @foreach($schools as $id => $school)
                            <option
                                value="{{ $id }}" {{ ($partner->school ? $partner->school->id : old('school_id')) == $id ? 'selected' : '' }}>{{ $school }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('school'))
                        <span class="text-danger">{{ $errors->first('school') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.school_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">{{ trans('crud.partner.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" maxlength="191"
                           name="name"
                           id="name" value="{{ old('name', $partner->name) }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="phone">{{ trans('crud.partner.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone"
                           id="phone" value="{{ old('phone', $partner->phone) }}"
                           data-inputmask="'mask': ['9{10,20}'], 'placeholder': ''"
                           data-mask required>
                    @if($errors->has('phone'))
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.phone_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="category">{{ trans('crud.partner.fields.category') }}</label>
                    <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category"
                            id="category" required>
                        <option value
                                disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Partner::CATEGORY_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('category', $partner->category) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="activity">{{ trans('crud.partner.fields.activity') }}</label>
                    <textarea class="form-control {{ $errors->has('activity') ? 'is-invalid' : '' }}" name="activity"
                              id="activity" required>{{ old('activity', $partner->activity) }}</textarea>
                    @if($errors->has('activity'))
                        <span class="text-danger">{{ $errors->first('activity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.activity_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="date">{{ trans('crud.partner.fields.date') }}</label>
                    <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text"
                           data-toggle="datetimepicker" data-target="#date"
                           name="date" id="date" value="{{ old('date', $partner->date) }}" required>
                    @if($errors->has('date'))
                        <span class="text-danger">{{ $errors->first('date') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="purpose">{{ trans('crud.partner.fields.purpose') }}</label>
                    <textarea class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose"
                              id="purpose" required>{{ old('purpose', $partner->purpose) }}</textarea>
                    @if($errors->has('purpose'))
                        <span class="text-danger">{{ $errors->first('purpose') }}</span>
                    @endif
                    <span class="help-block">{{ trans('crud.partner.fields.purpose_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="total_people">{{ trans('crud.partner.fields.total_people') }}</label>
                    <input class="form-control {{ $errors->has('total_people') ? 'is-invalid' : '' }}" type="number"
                           min="1"
                           name="total_people" id="total_people"
                           value="{{ old('total_people', $partner->total_people) }}" step="1" required>
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
        const formEdit = $('form#formEdit');

        Dropzone.options.photoDropzone = {
            url: '{{ route('admin.partners.storeMedia') }}',
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
                formEdit.find('input[name="photo"]').remove();
                formEdit.append('<input type="hidden" name="photo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove();
                if (file.status !== 'error') {
                    formEdit.find('input[name="photo"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($partner) && $partner->photo)
                let file = {!! json_encode($partner->photo) !!}
                        this.options.addedfile.call(this, file);
                file.previewElement.classList.add('dz-complete');
                formEdit.append('<input type="hidden" name="photo" value="' + file.file_name + '">');
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
