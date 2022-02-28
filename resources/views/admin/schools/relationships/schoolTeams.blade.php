<div class="m-3">
    @can('team_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.teams.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.team.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.team.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-schoolTeams">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.team.fields.school') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.name') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.status') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.gender') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.birth_date') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.aspect') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.position') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.document') }}
                        </th>
                        <th>
                            {{ trans('crud.team.fields.user') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teams as $key => $team)
                        <tr data-entry-id="{{ $team->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $team->school->name ?? '' }}
                            </td>
                            <td>
                                {{ $team->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Team::STATUS_SELECT[$team->status] ?? '' }}
                            </td>
                            <td>
                                {{ App\Team::GENDER_SELECT[$team->gender] ?? '' }}
                            </td>
                            <td>
                                {{ $team->birth_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Team::SECTOR_SELECT[$team->aspect] ?? '' }}
                            </td>
                            <td>
                                {{ App\Team::POSITION_SELECT[$team->position] ?? '' }}
                            </td>
                            <td>
                                @if($team->document)
                                    <a href="{{ $team->document->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $team->user->name ?? '' }}
                            </td>
                            <td>
                                @can('team_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.teams.show', $team->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('team_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.teams.edit', $team->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('team_delete')
                                    <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST"
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
                @can('team_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.teams.massDestroy') }}",
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
            $('.datatable-schoolTeams:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
