<div class="m-3">
    @can('cadre_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("school.cadres.create", ['school_slug' => $school_slug]) }}">
                    {{ trans('global.add') }} {{ trans('crud.cadre.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.cadre.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-workGroupCadres">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.cadre.fields.work_group') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.class') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.birth_date') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.address') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.hobby') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.position') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.letter') }}
                        </th>
                        <th>
                            {{ trans('crud.cadre.fields.user') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cadres as $key => $cadre)
                        <tr data-entry-id="{{ $cadre->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $cadre->work_group->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Cadre::GENDER_SELECT[$cadre->gender] ?? '' }}
                            </td>
                            <td>
                                {{ App\Cadre::CLASS_SELECT[$cadre->class] ?? '' }}
                            </td>
                            <td>
                                {{ $cadre->phone ?? '' }}
                            </td>
                            <td>
                                {{ $cadre->birth_date ?? '' }}
                            </td>
                            <td>
                                {{ $cadre->address ?? '' }}
                            </td>
                            <td>
                                {{ $cadre->hobby ?? '' }}
                            </td>
                            <td>
                                {{ App\Cadre::POSITION_SELECT[$cadre->position] ?? '' }}
                            </td>
                            <td>
                                @if($cadre->photo)
                                    <a href="{{ $cadre->photo->getUrl() }}" target="_blank">
                                        <img src="{{ $cadre->photo->getUrl() }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($cadre->letter)
                                    <a href="{{ $cadre->letter->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $cadre->user->name ?? '' }}
                            </td>
                            <td>
                                @can('cadre_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('school.cadres.show', $cadre->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('cadre_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('school.cadres.edit', $cadre->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('cadre_delete')
                                    <form action="{{ route('school.cadres.destroy', $cadre->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
                @can('cadre_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('school.cadres.massDestroy', ['school_slug' => $school_slug]) }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
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
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 1, 'desc' ]],
                pageLength: 10,
            });
            $('.datatable-workGroupCadres:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
