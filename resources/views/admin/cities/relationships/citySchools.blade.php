<div class="m-3">
    @can('school_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.schools.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.school.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.school.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-citySchools">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.school.fields.name') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.level') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.vision') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.status') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.address') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.email') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.total_students') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.total_teachers') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.total_land_area') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.total_building_area') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.logo') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.city') }}
                        </th>
                        <th>
                            {{ trans('crud.school.fields.user') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schools as $key => $school)
                        <tr data-entry-id="{{ $school->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $school->name ?? '' }}
                            </td>
                            <td>
                                {{ App\School::LEVEL_SELECT[$school->level] ?? '' }}
                            </td>
                            <td>
                                {{ $school->vision ?? '' }}
                            </td>
                            <td>
                                {{ App\School::STATUS_SELECT[$school->status] ?? '' }}
                            </td>
                            <td>
                                {{ $school->address ?? '' }}
                            </td>
                            <td>
                                {{ $school->phone ?? '' }}
                            </td>
                            <td>
                                {{ $school->email ?? '' }}
                            </td>
                            <td>
                                {{ $school->total_students ?? '' }}
                            </td>
                            <td>
                                {{ $school->total_teachers ?? '' }}
                            </td>
                            <td>
                                {{ $school->total_land_area ?? '' }}
                            </td>
                            <td>
                                {{ $school->total_building_area ?? '' }}
                            </td>
                            <td>
                                @if($school->logo)
                                    <a href="{{ $school->logo->getUrl() }}" target="_blank">
                                        <img src="{{ $school->logo->getUrl() }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($school->photo)
                                    <a href="{{ $school->photo->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $school->city->name ?? '' }}
                            </td>
                            <td>
                                {{ $school->user->name ?? '' }}
                            </td>
                            <td>
                                @can('school_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.schools.show', $school->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('school_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.schools.edit', $school->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('school_delete')
                                    <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('school_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.schools.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 10,
            });
            $('.datatable-citySchools:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
