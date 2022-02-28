<div class="m-3">
    @can('lesson_plan_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.lesson-plans.create") }}">
                    {{ trans('global.add') }} {{ trans('crud.lessonPlan.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('crud.lessonPlan.title_singular') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-calendarsLessonPlans">
                    <thead>
                    <tr>
                        <th style="width: 10px;">
                        <span style="display: none;">{{ trans('global.select_all') }}</span>
                    </th>
                    <th>
                        No
                    </th>
                    <th>
                            {{ trans('crud.lessonPlan.fields.school') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.ktsp_or_rpp') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.vision') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.mission') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.purpose') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.subject') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.teacher') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.class') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.aspect') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.hook') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.artwork') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.hour') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.period') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.syllabus') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.rpp') }}
                        </th>
                        <th>
                            {{ trans('crud.lessonPlan.fields.calendars') }}
                        </th>
                    <th>
                        {{ trans('global.action') }}
                    </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lessonPlans as $key => $lessonPlan)
                        <tr data-entry-id="{{ $lessonPlan->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $lessonPlan->school->name ?? '' }}
                            </td>
                            <td>
                                {{ App\LessonPlan::KTSP_OR_RPP_SELECT[$lessonPlan->ktsp_or_rpp] ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->vision ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->mission ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->purpose ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->subject ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->teacher ?? '' }}
                            </td>
                            <td>
                                {{ App\LessonPlan::CLASS_SELECT[$lessonPlan->class] ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->aspect->name ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->hook ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->artwork ?? '' }}
                            </td>
                            <td>
                                {{ $lessonPlan->hour ?? '' }}
                            </td>
                            <td>
                                {{ App\LessonPlan::PERIOD_SELECT[$lessonPlan->period] ?? '' }}
                            </td>
                            <td>
                                @if($lessonPlan->syllabus)
                                    <a href="{{ $lessonPlan->syllabus->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($lessonPlan->rpp)
                                    <a href="{{ $lessonPlan->rpp->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @foreach($lessonPlan->calendars as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('lesson_plan_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.lesson-plans.show', $lessonPlan->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('lesson_plan_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.lesson-plans.edit', $lessonPlan->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('lesson_plan_delete')
                                    <form action="{{ route('admin.lesson-plans.destroy', $lessonPlan->id) }}"
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
                @can('lesson_plan_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.lesson-plans.massDestroy') }}",
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
            $('.datatable-calendarsLessonPlans:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
