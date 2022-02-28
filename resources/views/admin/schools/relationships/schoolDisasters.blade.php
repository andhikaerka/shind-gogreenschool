<div class="m-3">
    @can('disaster_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.disasters.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.disaster.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.disaster.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-schoolDisasters">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.disaster.fields.school') }}
                        </th>
                        <th>
                            {{ trans('crud.disaster.fields.potential') }}
                        </th>
                        <th>
                            {{ trans('crud.disaster.fields.vulnerability') }}
                        </th>
                        <th>
                            {{ trans('crud.disaster.fields.impact') }}
                        </th>
                        <th>
                            {{ trans('crud.disaster.fields.threats') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($disasters as $key => $disaster)
                        <tr data-entry-id="{{ $disaster->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $disaster->school->name ?? '' }}
                            </td>
                            <td>
                                {{ $disaster->potential ?? '' }}
                            </td>
                            <td>
                                {{ $disaster->vulnerability ?? '' }}
                            </td>
                            <td>
                                {{ $disaster->impact ?? '' }}
                            </td>
                            <td>
                                @foreach($disaster->threats as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('disaster_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.disasters.show', $disaster->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('disaster_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.disasters.edit', $disaster->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('disaster_delete')
                                    <form action="{{ route('admin.disasters.destroy', $disaster->id) }}" method="POST"
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
                @can('disaster_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.disasters.massDestroy') }}",
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
            $('.datatable-schoolDisasters:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
