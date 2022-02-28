@extends('layouts.school')

@section('title')
    {{ trans('global.list') }} {{ trans('crud.oneYearActivity.title_singular') }} - {{ trans('panel.site_title') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('crud.oneYearActivity.title') }}
        </div>

        <div class="card-body">
            <p>
                Text coming soon...
            </p>
        </div>
    </div>



@endsection
