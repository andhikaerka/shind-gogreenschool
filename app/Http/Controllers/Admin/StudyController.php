<?php

namespace App\Http\Controllers\Admin;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudyRequest;
use App\Http\Requests\StoreStudyRequest;
use App\Http\Requests\UpdateStudyRequest;
use App\Partner;
use App\QualityReport;
use App\School;
use App\SchoolProfile;
use App\Study;
use App\Team;
use App\TeamStatus;
use App\WorkGroup;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudyController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('study_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Study::query()
                ->with(['snp_category', 'quality_report', 'work_group', 'work_group.work_group_name', 'work_group.aspect', 'partner', 'team_statuses', 'work_group.school_profile.school'])
                ->select(sprintf('%s.*', (new Study)->table));
            if ($request->get('year')) {
                $query->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            if ($request->get('school_id')) {
                $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'study_show';
                $editGate = 'study_edit';
                $deleteGate = 'study_delete';
                $crudRoutePart = 'studies';

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
            $table->addColumn('quality_report_waste_management', function ($row) {
                return $row->quality_report ? $row->quality_report->waste_management : '';
            });

            $table->editColumn('potential', function ($row) {
                return $row->potential ? $row->potential : "";
            });
            $table->editColumn('problem', function ($row) {
                return $row->problem ? $row->problem : "";
            });
            $table->editColumn('activity', function ($row) {
                return $row->activities ?? '';
            });
            $table->editColumn('behavioral', function ($row) {
                return $row->behavioral ? $row->behavioral : "";
            });
            $table->editColumn('physical', function ($row) {
                return $row->physical ? $row->physical : "";
            });
            $table->editColumn('kbm', function ($row) {
                return $row->kbm ? $row->kbm : "";
            });
            $table->editColumn('artwork', function ($row) {
                return $row->artwork ? $row->artwork : "";
            });
            $table->editColumn('period', function ($row) {
                return $row->period ? $row->period . ' Bulan' : '';
            });
            $table->editColumn('source', function ($row) {
                return $row->source ? $row->source : '';
            });
            $table->editColumn('cost', function ($row) {
                return $row->cost ? $row->cost : "";
            });
            $table->addColumn('work_group_aspect_name', function ($row) {
                return $row->work_group ? ($row->work_group->aspect ? $row->work_group->aspect->name : '') : '';
            });
            $table->addColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group->work_group_name ? $row->work_group->work_group_name->name : '') : '';
            });
            $table->addColumn('snp_category_name', function ($row) {
                return $row->snp_category ? $row->snp_category->name : '';
            });

            $table->addColumn('partner_name', function ($row) {
                return $row->partner ? $row->partner->name : '';
            });
            $table->addColumn('team_statuses_name', function ($row) {
                $labels = [];

                foreach ($row->team_statuses as $team_status) {
                    array_push($labels, $team_status->name);
                }

                return implode(', ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'quality_report', 'work_group', 'partner', 'activity']);

            return $table->make(true);
        }

        return view('admin.studies.index');
    }

    public function create()
    {
        abort_if(Gate::denies('study_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $qualityReports = [];

        $aspects = Aspect::all()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '0');

        $workGroups = [];

        $partners = [];

        $teamStatusQuery = TeamStatus::query();
        $teamStatuses = $teamStatusQuery->pluck('name', 'id');

        $maxPercentage = Study::MAX_PERCENTAGE;

        return view('admin.studies.create', compact('schools', 'qualityReports', 'aspects', 'workGroups', 'partners', 'teamStatuses', 'maxPercentage'));
    }

    public function store(StoreStudyRequest $request)
    {

        $study = Study::query()->create($request->all());

        if ($study) {
            $study->checklist_templates()->sync($request->get('checklist_templates', []));
            $study->team_statuses()->sync($request->get('team_statuses', []));

            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('admin.studies.index');

    }

    public function edit(Request $request, Study $study)
    {
        abort_if(Gate::denies('study_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $qualityReportQuery = QualityReport::query();
        $qualityReportQuery->whereHas('school_profile.school', function (Builder $builder) use ($request) {
            $builder->where('id', $request->get('school_id'));
        });
        $qualityReports = $qualityReportQuery->pluck('waste_management', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '0');

        $workGroups = [];
        $partners = [];

        $teamStatusQuery = Team::query();
        $teamStatuses = $teamStatusQuery->pluck('name', 'id');

        $maxPercentage = Study::MAX_PERCENTAGE;

        return view('admin.studies.edit', compact('schools', 'qualityReports', 'aspects', 'workGroups', 'partners', 'study', 'teamStatuses', 'maxPercentage'));
    }

    public function update(UpdateStudyRequest $request, Study $study)
    {
        $update = $study->update($request->all());
        $study->checklist_templates()->sync($request->get('checklist_templates', []));
        $study->team_statuses()->sync($request->get('team_statuses', []));

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('admin.studies.index');

    }

    public function show(Study $study)
    {
        abort_if(Gate::denies('study_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studies.show', compact( 'study'));
    }

    /**
     * @param Study $study
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Study $study)
    {
        abort_if(Gate::denies('study_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $study->delete();

        return back();

    }

    public function massDestroy(MassDestroyStudyRequest $request)
    {
        $query = Study::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
