@extends('layouts.school')

@section('title')
    {{ trans('global.list') }} {{ trans('crud.assessmentResult.title_singular') }} - {{ trans('panel.site_title') }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('crud.assessmentResult.title') }}
        </div>

        <div class="card-body">
            <p>
                Text coming soon...
            </p>
        </div>
    </div>
@endsection
