@extends('layouts.school')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.partner.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.name') }}
                        </th>
                        <td>
                            {{ $partner->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.phone') }}
                        </th>
                        <td>
                            {{ $partner->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.category') }}
                        </th>
                        <td>
                            {{ App\Partner::CATEGORY_SELECT[$partner->category] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.activity') }}
                        </th>
                        <td>
                            {{ $partner->activity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.date') }}
                        </th>
                        <td>
                            {{ $partner->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.purpose') }}
                        </th>
                        <td>
                            {{ $partner->purpose }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.total_people') }}
                        </th>
                        <td>
                            {{ $partner->total_people }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.partner.fields.photo') }}
                        </th>
                        <td>
                            @if($partner->photo)
                                <a href="{{ $partner->photo->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('school.partners.index', ['school_slug' => $school_slug]) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#partner_studies" role="tab" data-toggle="tab">
                    {{ trans('crud.study.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="partner_studies">
                @includeIf('school.partners.relationships.partnerStudies', ['studies' => $partner->partnerStudies])
            </div>
        </div>
    </div>

@endsection
