<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\School;
use App\TeamStatus;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryActivity = Activity::query();
            $queryActivity->with(['work_group', 'work_group.work_group_name', 'work_group.aspect', 'team_statuses', 'work_group.school_profile.school']);

            if ($request->get('school_id')) {
                $queryActivity->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year', date('Y'))) {
                $queryActivity->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $query = $queryActivity->select(sprintf('%s.*', (new Activity)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'activity_show';
                $editGate = 'activity_edit';
                $deleteGate = 'activity_delete';
                $crudRoutePart = 'activities';

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

            $table->editColumn('work_group_school_profile_school_name', function ($row) {
                return $row->work_group->school_profile->school ? $row->work_group->school_profile->school->name : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('activity', function ($row) {
                return $row->activity ? $row->activity : "";
            });
            $table->editColumn('advantage', function ($row) {
                return $row->advantage ? $row->advantage : "";
            });
            $table->editColumn('behavioral', function ($row) {
                return $row->behavioral ? $row->behavioral : "";
            });
            $table->editColumn('physical', function ($row) {
                return $row->physical ? $row->physical : "";
            });
            $table->addColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group->work_group_name ? $row->work_group->work_group_name->name : '') : '';
            });
            $table->addColumn('work_group_aspect_name', function ($row) {
                return $row->work_group ? ($row->work_group->aspect ? $row->work_group->aspect->name : '') : '';
            });
            $table->editColumn('team_statuses_name', function ($row) {
                $labels = [];

                foreach ($row->team_statuses as $team_status) {
                    $labels[] = sprintf('<span class="label label-info label-many badge badge-info">%s</span>', $team_status->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'work_group_work_group_name_name', 'work_group_aspect_name', 'team_statuses_name', 'document']);

            return $table->make(true);
        }

        return view('admin.activities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        $workGroups = [];

        return view('admin.activities.create', compact('schools', 'workGroups', 'aspects', 'teamStatuses'));
    }

    public function store(StoreActivityRequest $request)
    {

        $activity = Activity::query()->create($request->all());

        if ($activity) {
            $activity->team_statuses()->sync($request->get('team_statuses', []));

            if ($request->get('document', false)) {
                $activity->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.activities.create');
        } else {
            return redirect()->route('admin.activities.index');
        }
    }

    public function edit(Request $request, Activity $activity)
    {
        abort_if(Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        return view('admin.activities.edit', compact('schools', 'activity', 'aspects', 'teamStatuses', 'workGroups'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $update = $activity->update($request->all());

        if ($update) {
            $activity->team_statuses()->sync($request->get('team_statuses', []));

            if ($request->get('document', false)) {
                if (!$activity->document || $request->get('document') !== $activity->document->file_name) {
                    $activity->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
                }

            } elseif ($activity->document) {
                $activity->document->delete();
            }

            session()->flash('message', __('global.is_updated'));
        }

        return $request->get('adding_activities') ? redirect()->route('admin.activities.create') : redirect()->route('admin.activities.index');
    }

    public function show(Activity $activity)
    {
        abort_if(Gate::denies('activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.activities.show', compact('activity'));
    }

    /**
     * @param Activity $activity
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Activity $activity)
    {
        abort_if(Gate::denies('activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $activity->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyActivityRequest $request)
    {
        $query = Activity::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
