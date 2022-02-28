<div class="m-3">
    @can('partner_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.partners.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.partner.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.partner.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-schoolPartners">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.partner.fields.school') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.name') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.category') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.activity') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.date') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.purpose') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.total_people') }}
                        </th>
                        <th>
                            {{ trans('crud.partner.fields.photo') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($partners as $key => $partner)
                        <tr data-entry-id="{{ $partner->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $partner->school->name ?? '' }}
                            </td>
                            <td>
                                {{ $partner->name ?? '' }}
                            </td>
                            <td>
                                {{ $partner->phone ?? '' }}
                            </td>
                            <td>
                                {{ App\Partner::CATEGORY_SELECT[$partner->category] ?? '' }}
                            </td>
                            <td>
                                {{ $partner->activity ?? '' }}
                            </td>
                            <td>
                                {{ $partner->date ?? '' }}
                            </td>
                            <td>
                                {{ $partner->purpose ?? '' }}
                            </td>
                            <td>
                                {{ $partner->total_people ?? '' }}
                            </td>
                            <td>
                                @if($partner->photo)
                                    <a href="{{ $partner->photo->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('partner_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.partners.show', $partner->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('partner_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.partners.edit', $partner->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('partner_delete')
                                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST"
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
                @can('partner_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.partners.massDestroy') }}",
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
            $('.datatable-schoolPartners:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
