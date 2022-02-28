<div class="m-3">
    @can('study_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("school.studies.create", ['school_slug' => $school_slug]) }}">
                    {{ trans('global.add') }} {{ trans('crud.study.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.study.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-workGroupStudies">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.study.fields.quality_report') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.potential') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.problem') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.activity') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.behavioral') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.physical') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.kbm') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.artwork') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.period') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.cost') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.work_group') }}
                        </th>
                        <th>
                            {{ trans('crud.study.fields.partner') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($studies as $key => $study)
                        <tr data-entry-id="{{ $study->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $study->quality_report->waste_management ?? '' }}
                            </td>
                            <td>
                                {{ $study->potential ?? '' }}
                            </td>
                            <td>
                                {{ $study->problem ?? '' }}
                            </td>
                            <td>
                                {{ $study->activity ?? '' }}
                            </td>
                            <td>
                                {{ $study->behavioral ?? '' }}
                            </td>
                            <td>
                                {{ $study->physical ?? '' }}
                            </td>
                            <td>
                                {{ $study->kbm ?? '' }}
                            </td>
                            <td>
                                {{ $study->artwork ?? '' }}
                            </td>
                            <td>
                                {{ App\Study::PERIOD_SELECT[$study->period] ?? '' }}
                            </td>
                            <td>
                                {{ $study->cost ?? '' }}
                            </td>
                            <td>
                                {{ $study->work_group->name ?? '' }}
                            </td>
                            <td>
                                {{ $study->partner->name ?? '' }}
                            </td>
                            <td>
                                @can('study_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('school.studies.show', $study->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('study_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('school.studies.edit', $study->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('study_delete')
                                    <form action="{{ route('school.studies.destroy', $study->id) }}" method="POST"
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
                @can('study_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('school.studies.massDestroy', ['school_slug' => $school_slug]) }}",
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
            $('.datatable-workGroupStudies:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
