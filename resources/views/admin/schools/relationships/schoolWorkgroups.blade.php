<div class="m-3">
    @can('work_group_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.work-groups.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.workGroup.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.workGroup.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-schoolWorkGroups">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.workGroup.fields.school') }}
                        </th>
                        <th>
                            {{ trans('crud.schoolProfile.fields.year') }}
                        </th>
                        <th>
                            {{ trans('crud.workGroup.fields.name') }}
                        </th>
                        <th>
                            {{ trans('crud.workGroup.fields.field') }}
                        </th>
                        <th>
                            {{ trans('crud.workGroup.fields.tutor_1') }}
                        </th>
                        <th>
                            {{ trans('crud.workGroup.fields.tutor_2') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($workGroups as $key => $workGroup)
                        <tr data-entry-id="{{ $workGroup->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $workGroup->school->name ?? '' }}
                            </td>
                            <td>
                                {{ $workGroup->year ?? '' }}
                            </td>
                            <td>
                                {{ $workGroup->name ?? '' }}
                            </td>
                            <td>
                                {{ $workGroup->tutor_1 ?? '' }}
                            </td>
                            <td>
                                {{ $workGroup->tutor_2 ?? '' }}
                            </td>
                            <td>
                                @can('work_group_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.work-groups.show', $workGroup->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('work_group_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.work-groups.edit', $workGroup->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('work_group_delete')
                                    <form action="{{ route('admin.work-groups.destroy', $workGroup->id) }}"
                                          method="POST"
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
                @can('work_group_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.work-groups.massDestroy') }}",
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
            $('.datatable-schoolWorkGroups:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
