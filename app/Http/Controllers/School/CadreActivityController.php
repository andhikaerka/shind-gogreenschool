<?php

namespace App\Http\Controllers\School;

use App\CadreActivity;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCadreActivityRequest;
use App\Http\Requests\StoreCadreActivityRequest;
use App\Http\Requests\UpdateCadreActivityRequest;
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

class CadreActivityController extends Controller
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
        abort_if(Gate::denies('cadre_activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryCadreActivity = CadreActivity::query();
            $queryCadreActivity->with(['work_program.study.work_group', 'work_program']);
            $queryCadreActivity->whereHas('work_program.study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });/*
            if ($request->get('work_group_name_id')) {
                $queryCadreActivity->whereHas('work_program.study.work_group', function (Builder $builder) use ($request) {
                    $builder->where('work_group_name_id', $request->get('work_group_name_id'));
                });
            } */
            if ($request->get('aspect_id')) {
                $queryCadreActivity->whereHas('work_program.study.work_group', function (Builder $builder) use ($request) {
                    $builder->where('aspect_id', $request->get('aspect_id'));
                });
            }
            if ($request->get('year', date('Y'))) {
                $queryCadreActivity->whereHas('work_program.study.work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $query = $queryCadreActivity->select(sprintf('%s.*', (new CadreActivity)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'cadre_activity_show';
                $editGate = 'cadre_activity_edit';
                $deleteGate = 'cadre_activity_delete';
                $crudRoutePart = 'cadre-activities';

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
            $table->editColumn('results', function ($row) {
                return $row->results ? $row->results : "";
            });
            $table->editColumn('problem', function ($row) {
                return $row->problem ? $row->problem : "";
            });
            $table->editColumn('behavioral', function ($row) {
                return $row->behavioral ? $row->behavioral : "";
            });
            $table->editColumn('physical', function ($row) {
                return $row->physical ? $row->physical : "";
            });
            $table->editColumn('plan', function ($row) {
                return $row->plan ? $row->plan : "";
            });
            $table->editColumn('condition', function ($row) {
                return isset(CadreActivity::CONDITION_SELECT[$row->condition]) ? CadreActivity::CONDITION_SELECT[$row->condition] : "";
            });
            $table->addColumn('work_program_study_work_group_work_group_name_name', function ($row) {
                return $row->work_program ? ($row->work_program->study ? ($row->work_program->study->work_group ? ($row->work_program->study->work_group->work_group_name ? $row->work_program->study->work_group->work_group_name->name : '') : '') : '') : '';
            });
            $table->addColumn('work_program_plan', function ($row) {
                return $row->work_program ? $row->work_program->plan : '';
            });
            $table->addColumn('work_program_tutor', function ($row) {
                return $row->work_program->tutor;
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

            $table->rawColumns(['actions', 'placeholder', 'work_program_plan', 'work_program_tutor', 'team_statuses_name', 'document']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->cadreActivitiesScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->cadreActivitiesScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->cadreActivitiesScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.cadreActivities.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('cadre_activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $workGroupsQuery = WorkGroup::query();
        $workGroupsQuery
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select(['work_groups.id', 'work_group_names.name']);
        $workGroupsQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        $maxPercentage = CadreActivity::MAX_PERCENTAGE;
        $percentageAmountNow = CadreActivity::query()
            ->whereHas('work_program.study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->sum('percentage');
        $maxPercentage = $maxPercentage - $percentageAmountNow;

        return view('school.cadreActivities.create', compact('school_slug', 'workGroups', 'teamStatuses', 'maxPercentage'));
    }

    public function store(StoreCadreActivityRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $request->merge(['percentage' => CadreActivity::PERCENTAGE_SELECT[$request->get('condition')]]);
        $cadreActivity = CadreActivity::query()->create($request->all());

        if ($cadreActivity) {
            $cadreActivity->team_statuses()->sync($request->get('team_statuses', []));

            if ($request->get('document', false)) {
                $cadreActivity->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.cadre-activities.create', ['school_slug' => $school_slug, 'year' => $cadreActivity->work_program->study->work_group->school_profile->year]);
        } else {
            return redirect()->route('school.cadre-activities.index', ['school_slug' => $school_slug, 'year' => $cadreActivity->work_program->study->work_group->school_profile->year]);
        }
    }

    public function edit($school_slug, CadreActivity $cadreActivity)
    {
        abort_if(Gate::denies('cadre_activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities', function (Builder $builder) use ($cadreActivity) {
                $builder->where('id', $cadreActivity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $workGroupsQuery = WorkGroup::query();
        $workGroupsQuery
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select(['work_groups.id', 'work_group_names.name']);
        $workGroupsQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        $maxPercentage = CadreActivity::MAX_PERCENTAGE;
        $percentageAmountNow = CadreActivity::query()
            ->where('id', '!=', $cadreActivity['id'])
            ->whereHas('work_program.study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->sum('percentage');
        $maxPercentage = $maxPercentage - $percentageAmountNow;

        return view('school.cadreActivities.edit', compact('school_slug', 'cadreActivity', 'workGroups', 'teamStatuses', 'maxPercentage'));
    }

    public function update(UpdateCadreActivityRequest $request, $school_slug, CadreActivity $cadreActivity)
    {
        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities', function (Builder $builder) use ($cadreActivity) {
                $builder->where('id', $cadreActivity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $request->merge(['percentage' => CadreActivity::PERCENTAGE_SELECT[$request->get('condition')]]);
        $update = $cadreActivity->update($request->all());

        $cadreActivity->team_statuses()->sync($request->get('team_statuses', []));

        if ($request->get('document', false)) {
            if (!$cadreActivity->document || $request->get('document') !== $cadreActivity->document->file_name) {
                $cadreActivity->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

        } elseif ($cadreActivity->document) {
            $cadreActivity->document->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return $request->get('adding_cadre_activities') ? redirect()->route('school.cadre-activities.create', ['school_slug' => $school_slug]) : redirect()->route('school.cadre-activities.index', ['school_slug' => $school_slug, 'year' => $cadreActivity->work_program->study->work_group->school_profile->year]);
    }

    public function show($school_slug, CadreActivity $cadreActivity)
    {
        abort_if(Gate::denies('cadre_activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities', function (Builder $builder) use ($cadreActivity) {
                $builder->where('id', $cadreActivity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.cadreActivities.show', compact('school_slug', 'cadreActivity'));
    }

    /**
     * @param $school_slug
     * @param CadreActivity $cadreActivity
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, CadreActivity $cadreActivity)
    {
        abort_if(Gate::denies('cadre_activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities', function (Builder $builder) use ($cadreActivity) {
                $builder->where('id', $cadreActivity['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $cadreActivity->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyCadreActivityRequest $request, $school_slug)
    {
        $query = CadreActivity::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('work_program.study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
