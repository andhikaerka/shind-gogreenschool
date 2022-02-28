<?php

namespace App\Http\Controllers\School;

use App\Activity;
use App\ActivityImplementation;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActivityImplementationRequest;
use App\Http\Requests\StoreActivityImplementationRequest;
use App\Http\Requests\UpdateActivityImplementationRequest;
use App\School;
use App\WorkGroup;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ActivityImplementationController extends Controller
{
    /**
     * @param Request $request
     * @param $school_slug
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('activity_implementation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryActivityImplementation = ActivityImplementation::query();
            $queryActivityImplementation->whereHas('activity.work_group.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            $queryActivityImplementation->whereHas('activity.partner.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            $query = $queryActivityImplementation->select(sprintf('%s.*', (new ActivityImplementation)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'activity_implementation_show';
                $editGate = 'activity_implementation_edit';
                $deleteGate = 'activity_implementation_delete';
                $crudRoutePart = 'activity-implementations';

                return view('partials.dataTablesActions-school', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'school_slug'
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

        return view('school.activityImplementations.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('activity_implementation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $workGroupsQuery = WorkGroup::query();
        $workGroupsQuery->whereHas('school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $activitiesQuery = Activity::query();
        $activitiesQuery->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $activities = $activitiesQuery->pluck('potential', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.activityImplementations.create', compact('school_slug', 'workGroups', 'activities'));
    }

    public function store(StoreActivityImplementationRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $request->merge(['school_id' => auth()->user()->isSTC]);
        $activityImplementation = ActivityImplementation::query()->create($request->all());

        if ($activityImplementation) {
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('school.activity-implementations.index', ['school_slug' => $school_slug]);

    }

    public function edit($school_slug, ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->findOrFail(auth()->user()->isSTC);

        $workGroupsQuery = WorkGroup::query();
        $workGroupsQuery->whereHas('school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $activitiesQuery = Activity::query();
        $activitiesQuery->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $activities = $activitiesQuery->pluck('potential', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.activityImplementations.edit', compact('school_slug', 'activityImplementation', 'workGroups', 'activities'));
    }

    public function update(UpdateActivityImplementationRequest $request, $school_slug, ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->findOrFail(auth()->user()->isSTC);

        $activityImplementation->update($request->all());

        return redirect()->route('school.activity-implementations.index', ['school_slug' => $school_slug]);

    }

    public function show($school_slug, ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('school.activityImplementations.show', compact('school_slug', 'activityImplementation'));
    }

    /**
     * @param $school_slug
     * @param ActivityImplementation $activityImplementation
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, ActivityImplementation $activityImplementation)
    {
        abort_if(Gate::denies('activity_implementation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->findOrFail(auth()->user()->isSTC);

        $activityImplementation->delete();

        return back();

    }

    public function massDestroy(MassDestroyActivityImplementationRequest $request, $school_slug)
    {
        $queryActivityImplementation = ActivityImplementation::query();
        $queryActivityImplementation->whereHas('activity.work_group.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $queryActivityImplementation->whereHas('activity.partner.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $queryActivityImplementation->whereIn('id', $request->get('ids'))->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
