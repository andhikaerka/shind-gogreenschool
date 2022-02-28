<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCurriculumCalendarRequest;
use App\Http\Requests\StoreCurriculumCalendarRequest;
use App\Http\Requests\UpdateCurriculumCalendarRequest;
use App\CurriculumCalendar;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CurriculumCalendarController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('curriculum_calendar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CurriculumCalendar::query()->select(sprintf('%s.*', (new CurriculumCalendar)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'curriculum_calendar_show';
                $editGate = 'curriculum_calendar_edit';
                $deleteGate = 'curriculum_calendar_delete';
                $crudRoutePart = 'curriculum-calendars';

                return view('partials.dataTablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.curriculumCalendars.index');
    }

    public function create()
    {
        abort_if(Gate::denies('curriculum_calendar_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.curriculumCalendars.create');
    }

    public function store(StoreCurriculumCalendarRequest $request)
    {
        $curriculumCalendar = CurriculumCalendar::query()->create($request->all());

        if ($curriculumCalendar) {
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('admin.curriculum-calendars.index');

    }

    public function edit(CurriculumCalendar $curriculumCalendar)
    {
        abort_if(Gate::denies('curriculum_calendar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.curriculumCalendars.edit', compact('curriculumCalendar'));
    }

    public function update(UpdateCurriculumCalendarRequest $request, CurriculumCalendar $curriculumCalendar)
    {
        $curriculumCalendar->update($request->all());

        return redirect()->route('admin.curriculum-calendars.index');

    }

    public function show(CurriculumCalendar $curriculumCalendar)
    {
        abort_if(Gate::denies('curriculum_calendar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $curriculumCalendar->load('calendarsLessonPlans');

        return view('admin.curriculumCalendars.show', compact('curriculumCalendar'));
    }

    /**
     * @param CurriculumCalendar $curriculumCalendar
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(CurriculumCalendar $curriculumCalendar)
    {
        abort_if(Gate::denies('curriculum_calendar_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $curriculumCalendar->delete();

        return back();

    }

    public function massDestroy(MassDestroyCurriculumCalendarRequest $request)
    {
        CurriculumCalendar::query()->whereIn('id', $request->get('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
