<div class="m-3">
    @can('work_program_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("school.work-programs.create", ['school_slug' => $school_slug]) }}">
                    {{ trans('global.add') }} {{ trans('crud.workProgram.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.workProgram.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-studyWorkPrograms">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.workProgram.fields.work_group') }}
                        </th>
                        <th>
                            {{ trans('crud.workProgram.fields.study') }}
                        </th>
                        <th>
                            {{ trans('crud.workProgram.fields.condition') }}
                        </th>
                        <th>
                            {{ trans('crud.workProgram.fields.plan') }}
                        </th>
                        <th>
                            {{ trans('crud.workProgram.fields.activity') }}
                        </th>
                        <th>
                            {{ trans('crud.workProgram.fields.featured') }}
                        </th>
                        <th>
                            {{ trans('crud.workProgram.fields.photo') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($workPrograms as $key => $workProgram)
                        <tr data-entry-id="{{ $workProgram->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $workProgram->work_group->name ?? '' }}
                            </td>
                            <td>
                                {{ $workProgram->study->potential ?? '' }}
                            </td>
                            <td>
                                {{ $workProgram->condition ?? '' }}
                            </td>
                            <td>
                                {{ $workProgram->plan ?? '' }}
                            </td>
                            <td>
                                {{ $workProgram->activity ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $workProgram->featured ?? '' }}</span>
                                <input type="checkbox"
                                       disabled="disabled" {{ $workProgram->featured ? 'checked' : '' }}>
                            </td>
                            <td>
                                @if($workProgram->photo)
                                    <a href="{{ $workProgram->photo->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('work_program_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('school.work-programs.show', $workProgram->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('work_program_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('school.work-programs.edit', $workProgram->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('work_program_delete')
                                    <form action="{{ route('school.work-programs.destroy', $workProgram->id) }}"
                                          method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
                @can('work_program_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('school.work-programs.massDestroy', ['school_slug' => $school_slug]) }}",
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
            $('.datatable-studyWorkPrograms:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
