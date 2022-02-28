<?php

namespace App\Http\Controllers\Admin;

use App\CadreActivity;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCadreActivityRequest;
use App\Http\Requests\StoreCadreActivityRequest;
use App\Http\Requests\UpdateCadreActivityRequest;
use App\School;
use App\TeamStatus;
use App\WorkGroup;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CadreActivityController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('cadre_activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryCadreActivity = CadreActivity::query();
            $queryCadreActivity->with(['work_program.study.work_group', 'work_program.study.work_group.school_profile.school', 'work_program']);

            if ($request->get('school_id')) {
                $queryCadreActivity->whereHas('work_program.study.work_group.school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
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

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cadre_activity_show';
                $editGate = 'cadre_activity_edit';
                $deleteGate = 'cadre_activity_delete';
                $crudRoutePart = 'cadre-activities';

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

            $table->editColumn('work_program_study_work_group_school_profile_school_name', function ($row) {
                return $row->work_program->study->work_group->school_profile->school ? $row->work_program->study->work_group->school_profile->school->name : "";
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

            return $table->make(true);
        }

        return view('admin.cadreActivities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cadre_activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        $maxPercentage = CadreActivity::MAX_PERCENTAGE;

        return view('admin.cadreActivities.create', compact('schools', 'workGroups', 'teamStatuses', 'maxPercentage'));
    }

    public function store(StoreCadreActivityRequest $request)
    {

        $cadreActivity = CadreActivity::query()->create($request->all());

        if ($cadreActivity) {
            $cadreActivity->team_statuses()->sync($request->get('team_statuses', []));

            if ($request->get('document', false)) {
                $cadreActivity->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.cadre-activities.create');
        } else {
            return redirect()->route('admin.cadre-activities.index');
        }
    }

    public function edit(Request $request, CadreActivity $cadreActivity)
    {
        abort_if(Gate::denies('cadre_activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        $maxPercentage = CadreActivity::MAX_PERCENTAGE;

        return view('admin.cadreActivities.edit', compact('schools', 'cadreActivity', 'workGroups', 'teamStatuses', 'maxPercentage'));
    }

    public function update(UpdateCadreActivityRequest $request, CadreActivity $cadreActivity)
    {
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

        return $request->get('adding_cadre_activities') ? redirect()->route('admin.cadre-activities.create') : redirect()->route('admin.cadre-activities.index');
    }

    public function show(CadreActivity $cadreActivity)
    {
        abort_if(Gate::denies('cadre_activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cadreActivities.show', compact( 'cadreActivity'));
    }

    /**
     * @param CadreActivity $cadreActivity
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(CadreActivity $cadreActivity)
    {
        abort_if(Gate::denies('cadre_activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $cadreActivity->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyCadreActivityRequest $request)
    {
        $query = CadreActivity::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
