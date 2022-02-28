<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStudyRequest;
use App\Http\Requests\StoreStudyRequest;
use App\Http\Requests\UpdateStudyRequest;
use App\Partner;
use App\Environment;
use App\School;
use App\SchoolProfile;
use App\SnpCategory;
use App\Study;
use App\Team;
use App\TeamStatus;
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
use DB;
use App\BudgetPlan;
use App\LessonPlan;

class StudyController extends Controller
{
    /**
     * @param Request $request
     * @param $school_slug
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('study_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Study::with([
                'snp_category',
                'quality_report',
                'work_group',
                'work_group.work_group_name',
                'work_group.aspect',
                'partner',
                'team_statuses',
                'environmentalIssue',
                'lessonPlan'
                ])->select(sprintf('%s.*', (new Study)->table));
            if ($request->get('year')) {
                $query->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            /*$query->whereHas('quality_report.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });*/
            $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            /*$query->whereHas('partner.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });*/
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'study_show';
                $editGate = 'study_edit';
                $deleteGate = 'study_delete';
                $crudRoutePart = 'studies';

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
            $table->addColumn('environment', function ($row) {
                return $row->environment ? $row->environment->isi : '';
            });
            $table->addColumn('environmental_issue', function ($row) {
                return $row->environmentalIssue ? $row->environmentalIssue->potency : '';
            });
            $table->editColumn('potential', function ($row) {
                return $row->potential ? $row->potential : "";
            });
            $table->editColumn('problem', function ($row) {
                return $row->problem ? $row->problem : "";
            });
            $table->editColumn('activity', function ($row) {
                return $row->activities;
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
            $table->editColumn('lesson_plan', function ($row) {
                return $row->lessonPlan ? 'Kelas : '.$row->lessonPlan->class
                .'; Mata Pelajaran : '.$row->lessonPlan->subject
                .'; Semester : '.$row->lessonPlan->period.';' : '';
            });
            $table->editColumn('budget_plan', function ($row) {
                return $row->budgetPlan ? 'Deskripsi : '.$row->budgetPlan->description
                .'; Sumber RAB : '.$row->budgetPlan->source
                .'; RAKS : '.$row->budgetPlan->cost.';' : '';
            });
            $table->editColumn('source', function ($row) {
                return $row->source ? $row->source : '';
            });
            $table->editColumn('cost', function ($row) {
                return $row->cost ? 'Rp' . number_format($row->cost, 0, ',', '.') : "";
            });
            $table->addColumn('work_group_aspect_name', function ($row) {
                return $row->work_group ? ($row->work_group->aspect ? $row->work_group->aspect->name : '') : '';
            });
            $table->addColumn('work_group_name', function ($row) {
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

            $table->rawColumns(['actions', 'placeholder', 'environment', 'work_group', 'partner', 'activity', 'environmental_issue']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->studiesScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->studiesScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->studiesScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.studies.index', compact('school_slug'));
    }

    public function create($school_slug, Request $request)
    {
        abort_if(Gate::denies('study_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $environmentQuery = Environment::query();
        $environmentQuery->join('school_profiles', 'environments.school_profile_id', '=', 'school_profiles.id');
        $environmentQuery->selectRaw("environments.id as id, CONCAT('Tahun: ',school_profiles.year,'; " . (trans('crud.environment.fields.isi')) . ": ', isi, '; " . (trans('crud.environment.fields.proses')) . ": ', proses) AS text");
        $environmentQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $environmentQuery->where('school_profiles.year', $request->get('year', date('Y')));
        $environments = $environmentQuery->pluck('text', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '0');

        $partnersQuery = Partner::query();
        $partnersQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $partners = $partnersQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatuses = TeamStatus::pluck('name', 'id');

        $maxPercentage = Study::MAX_PERCENTAGE;
        $percentageAmountNow = Study::query()
            /*->whereHas('quality_report.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })*/
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            /*->whereHas('partner.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })*/
            ->sum('percentage');
        $maxPercentage = $maxPercentage - $percentageAmountNow;

        $environmentalIssues = \App\EnvironmentalIssue::query()
            ->join('school_profiles', 'environmental_issues.school_profile_id', '=', 'school_profiles.id')
            ->where('school_profiles.year', $request->get('year', date('Y')))
            ->select(
            DB::raw("CONCAT('Tahun: ',school_profiles.year,'; Potensi Isu: ',potency,'; Masalah: ',problem) AS name"),'environmental_issues.id as id')
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->pluck('name', 'id');

        $snpCategories = SnpCategory::query()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.studies.create', compact('school_slug', 'environments', 'aspects', 'partners', 'teamStatuses', 'maxPercentage', 'snpCategories', 'environmentalIssues'));
    }

    public function store(StoreStudyRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $study = Study::query()->create($request->all());

        if ($study) {
            $study->checklist_templates()->sync($request->get('checklist_templates', []));
            $study->team_statuses()->sync($request->get('team_statuses', []));

            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('school.studies.index', ['school_slug' => $school_slug, 'year' => $request->get('year', date('Y'))]);

    }

    public function edit($school_slug, Study $study)
    {
        abort_if(Gate::denies('study_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies', function (Builder $builder) use ($study) {
                $builder->where('id', $study['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $environmentQuery = Environment::query();
        $environmentQuery->selectRaw("id, CONCAT('" . (trans('crud.environment.fields.isi')) . ": ', isi, '; " . (trans('crud.environment.fields.proses')) . ": ', proses) AS text");
        $environmentQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $environments = $environmentQuery->pluck('text', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '0');

        $workGroupsQuery = WorkGroup::query()
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select('work_groups.id', 'work_group_names.name');
        $workGroupsQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $partnersQuery = Partner::query();
        $partnersQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $partners = $partnersQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatusQuery = TeamStatus::query();
        $teamStatuses = $teamStatusQuery->pluck('name', 'id');

        $snpCategories = SnpCategory::query()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $environmentalIssues = \App\EnvironmentalIssue::select(
            DB::raw("CONCAT('Potensi Isu: ',potency,'; Masalah: ',problem) AS name"),'id')
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->pluck('name', 'id');


        return view('school.studies.edit', compact('school_slug', 'environments', 'aspects', 'workGroups', 'partners', 'study', 'teamStatuses', 'snpCategories', 'environmentalIssues'));
    }

    public function update(UpdateStudyRequest $request, $school_slug, Study $study)
    {
        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies', function (Builder $builder) use ($study) {
                $builder->where('id', $study['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $study->update($request->all());
        $study->checklist_templates()->sync($request->get('checklist_templates', []));
        $study->team_statuses()->sync($request->get('team_statuses', []));

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.studies.index', ['school_slug' => $school_slug, 'year' => $study->work_group->school_profile->year]);

    }

    public function show($school_slug, Study $study)
    {
        abort_if(Gate::denies('study_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies', function (Builder $builder) use ($study) {
                $builder->where('id', $study['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.studies.show', compact('school_slug', 'study'));
    }

    /**
     * @param $school_slug
     * @param Study $study
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Study $study)
    {
        abort_if(Gate::denies('study_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies', function (Builder $builder) use ($study) {
                $builder->where('id', $study['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $study->delete();

        return back();

    }

    public function massDestroy(MassDestroyStudyRequest $request, $school_slug)
    {
        $query = Study::query()->whereIn('id', $request->get('ids'));
        /* $query->whereHas('quality_report.school_profile.school', function (Builder $builder) use ($school_slug) {
             $builder->where('slug', $school_slug);
         });*/
        $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        /*$query->whereHas('partner.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });*/
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
