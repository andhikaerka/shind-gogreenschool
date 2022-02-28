@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('crud.cadre.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.cadres.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('crud.workGroup.fields.school') }}
                        </th>
                        <td>
                            {{ $cadre->work_group->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.work_group') }}
                        </th>
                        <td>
                            {{ $cadre->work_group->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.name') }}
                        </th>
                        <td>
                            {{ $cadre->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Cadre::GENDER_SELECT[$cadre->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.class') }}
                        </th>
                        <td>
                            {{ App\Cadre::CLASS_SELECT[$cadre->class] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.phone') }}
                        </th>
                        <td>
                            {{ $cadre->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.birth_date') }}
                        </th>
                        <td>
                            {{ $cadre->birth_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.address') }}
                        </th>
                        <td>
                            {{ $cadre->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.hobby') }}
                        </th>
                        <td>
                            {{ $cadre->hobby }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.position') }}
                        </th>
                        <td>
                            {{ App\Cadre::POSITION_SELECT[$cadre->position] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.photo') }}
                        </th>
                        <td>
                            @if($cadre->photo)
                                <a href="{{ $cadre->photo->getUrl() }}" target="_blank">
                                    <img src="{{ $cadre->photo->getUrl() }}" width="50px" height="50px" alt="">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.cadre.fields.letter') }}
                        </th>
                        <td>
                            @if($cadre->letter)
                                <a href="{{ $cadre->letter->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.email') }}
                        </th>
                        <td>
                            {{ $cadre->user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('crud.user.fields.username') }}
                        </th>
                        <td>
                            {{ $cadre->user->username }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.cadres.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
