<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\ActivityImplementation;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActivityImplementationRequest;
use App\Http\Requests\StoreActivityImplementationRequest;
use App\Http\Requests\UpdateActivityImplementationRequest;
use App\School;
use App\WorkGroup;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ActivityImplementationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('activity_implementation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryActivityImplementation = ActivityImplementation::query();

            if ($request->get('school_id')) {
                $queryActivityImplementation->whereHas('activity.work_group.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            $queryActivityImplementation->whereHas('activity.partner.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            });
            $query = $queryActivityImplementation->select(sprintf('%s.*', (new ActivityImplementation)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'activity_implementation_show';
                $editGate = 'activity_implementation_edit';
                $deleteGate = 'activity_implementation_delete';
                $crudRoutePart = 'activity-implementations';

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
            $table->addColumn('work_group_name', function ($row) {
                return $row->work_group ? $row->work_group->name : '';
            });
            $table->addColumn('activity_potential', function ($row) {
                return $row->activity ? $row->activity->potential : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school']);

            return $table->make(true);
        }

        return view('admin.activityImplementations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('activity_implementation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];
        $activities = [];

        return view('admin.activityImplementations.create', compact('schools', 'workGroups', 'activities'));
    }

    public function store(StoreActivityImplementationRequest $request)
    {

        $request->merge(['school_id' => auth()->user()->isSTC]);
        $activityImplementation = ActivityImplementation::query()->create($request->all());

        if ($activityImplementation) {
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('admin.activity-implementations.index');

    }

    public function edit(Request $request, ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

        $activitiesQuery = Activity::query();
        $activitiesQuery->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
            $builder->where('id', $request->get('school_id'));
        });
        $activities = $activitiesQuery->pluck('potential', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.activityImplementations.edit', compact('schools', 'activityImplementation', 'workGroups', 'activities'));
    }

    public function update(UpdateActivityImplementationRequest $request, ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activityImplementation->update($request->all());

        return redirect()->route('admin.activity-implementations.index');

    }

    public function show(ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.activityImplementations.show', compact( 'activityImplementation'));
    }

    /**
     * @param ActivityImplementation $activityImplementation
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activityImplementation->delete();

        return back();

    }

    public function massDestroy(MassDestroyActivityImplementationRequest $request)
    {
        $queryActivityImplementation = ActivityImplementation::query();
        $items = $queryActivityImplementation->whereIn('id', $request->get('ids'))->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
