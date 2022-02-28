<?php

namespace App\Http\Controllers\School;

use App\Activity;
use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Partner;
use App\School;
use App\SchoolProfile;
use App\TeamStatus;
use App\WorkGroup;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param Request $request
     * @param $school_slug
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryActivity = Activity::query();
            $queryActivity->with(['work_group', 'work_group.work_group_name', 'work_group.aspect', 'team_statuses']);
            $queryActivity->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('work_group_name_id')) {
                $queryActivity->whereHas('work_group', function (Builder $builder) use ($request) {
                    $builder->where('work_group_name_id', $request->get('work_group_name_id'));
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

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'activity_show';
                $editGate = 'activity_edit';
                $deleteGate = 'activity_delete';
                $crudRoutePart = 'activities';

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

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->activitiesScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->activitiesScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->activitiesScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.activities.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        return view('school.activities.create', compact('school_slug', 'aspects', 'teamStatuses'));
    }

    public function store(StoreActivityRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $activity = Activity::query()->create($request->all());

        if ($activity) {
            $activity->team_statuses()->sync($request->get('team_statuses', []));

            if ($request->get('document', false)) {
                $activity->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.activities.create', ['school_slug' => $school_slug, 'year' => $activity->work_group->school_profile->year]);
        } else {
            return redirect()->route('school.activities.index', ['school_slug' => $school_slug, 'year' => $activity->work_group->school_profile->year]);
        }
    }

    public function edit($school_slug, Activity $activity)
    {
        abort_if(Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupActivities', function (Builder $builder) use ($activity) {
                $builder->where('id', $activity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        return view('school.activities.edit', compact('school_slug', 'activity', 'aspects', 'teamStatuses'));
    }

    public function update(UpdateActivityRequest $request, $school_slug, Activity $activity)
    {
        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupActivities', function (Builder $builder) use ($activity) {
                $builder->where('id', $activity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

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

        return $request->get('adding_activities') ? redirect()->route('school.activities.create', ['school_slug' => $school_slug]) : redirect()->route('school.activities.index', ['school_slug' => $school_slug]);
    }

    public function show($school_slug, Activity $activity)
    {
        abort_if(Gate::denies('activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupActivities', function (Builder $builder) use ($activity) {
                $builder->where('id', $activity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.activities.show', compact('school_slug', 'activity'));
    }

    /**
     * @param $school_slug
     * @param Activity $activity
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Activity $activity)
    {
        abort_if(Gate::denies('activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupActivities', function (Builder $builder) use ($activity) {
                $builder->where('id', $activity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $activity->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyActivityRequest $request, $school_slug)
    {
        $query = Activity::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
