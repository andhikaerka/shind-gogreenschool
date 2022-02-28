@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.change_password') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("profile.password.update") }}">
                @csrf
                <div class="form-group">
                    <label class="required" for="password">{{ trans('global.new_password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password"
                           name="password" id="password" required>
                    @if($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required"
                           for="password_confirmation">{{ trans('global.login_password_confirmation') }}</label>
                    <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                           type="password" name="password_confirmation" id="password_confirmation" required>
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
