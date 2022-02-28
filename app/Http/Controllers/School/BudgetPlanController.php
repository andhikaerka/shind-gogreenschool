<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\BudgetPlan;
use App\SnpCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBudgetPlanRequest;
use App\Http\Requests\StoreBudgetPlanRequest;
use App\Http\Requests\UpdateBudgetPlanRequest;
use App\School;
use App\SchoolProfile;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BudgetPlanController extends Controller
{
    /**
     * @param Request $request
     * @param $school_slug
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('budget_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryBudgetPlan = BudgetPlan::query()
                ->with(['snp_category'])
                ->select(sprintf('%s.*', (new BudgetPlan)->table));
            $queryBudgetPlan->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year')) {
                $queryBudgetPlan->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($queryBudgetPlan);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'budget_plan_show';
                $editGate = 'budget_plan_edit';
                $deleteGate = 'budget_plan_delete';
                $crudRoutePart = 'budget-plans';

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

            $table->editColumn('aspect_name', function ($row) {
                return $row->aspect ? $row->aspect->name : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('cost', function ($row) {
                return $row->cost ? 'Rp' . number_format($row->cost, 0, ',', '.') : "";
            });
            $table->addColumn('snp_category_name', function ($row) {
                return $row->snp_category ? $row->snp_category->name : '';
            });
            $table->editColumn('source', function ($row) {
                return $row->source ? $row->source : '';
            });
            $table->editColumn('pic', function ($row) {
                return $row->pic ? $row->pic : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'school']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->budgetPlansScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->budgetPlansScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->budgetPlansScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.budgetPlans.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('budget_plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $snpCategories = SnpCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.budgetPlans.create', compact('school_slug', 'aspects', 'snpCategories'));
    }

    public function store(StoreBudgetPlanRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfileQuery = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC);
        if($request->year){
            $schoolProfileQuery->where('year', $request->year);
        }else{
            $schoolProfileQuery->where('year', date('Y'));
        }
        $schoolProfile = $schoolProfileQuery->first();
        if (!$schoolProfile) {
            $latestSchoolProfile = SchoolProfile::query()
                ->where('school_id', auth()->user()->isSTC)
                ->orderBy('year', 'desc')
                ->first();

            $schoolProfile = SchoolProfile::query()->create([
                'school_id' => auth()->user()->isSTC,
                'year' => $request->has('year') ? $request->has('year') : date('Y'),
                'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
            ]);
        }

        $request->merge(['school_profile_id' => $schoolProfile['id']]);
        $budgetPlan = BudgetPlan::query()->create($request->all());

        if ($budgetPlan) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.budget-plans.create', ['school_slug' => $school_slug, 'year' => $request->year]);
        } else {
            return redirect()->route('school.budget-plans.index', ['school_slug' => $school_slug, 'year' => $request->year]);
        }
    }

    public function edit($school_slug, BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileBudgetPlans', function (Builder $builder) use ($budgetPlan) {
                $builder->where('id', $budgetPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $snpCategories = SnpCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.budgetPlans.edit', compact('school_slug', 'budgetPlan', 'aspects', 'snpCategories'));
    }

    public function update(UpdateBudgetPlanRequest $request, $school_slug, BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileBudgetPlans', function (Builder $builder) use ($budgetPlan) {
                $builder->where('id', $budgetPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $budgetPlan->update($request->all());

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.budget-plans.index', ['school_slug' => $school_slug, 'year' => $budgetPlan->school_profile->year]);

    }

    public function show($school_slug, BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileBudgetPlans', function (Builder $builder) use ($budgetPlan) {
                $builder->where('id', $budgetPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.budgetPlans.show', compact('school_slug', 'budgetPlan'));
    }

    /**
     * @param $school_slug
     * @param BudgetPlan $budgetPlan
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileBudgetPlans', function (Builder $builder) use ($budgetPlan) {
                $builder->where('id', $budgetPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $budgetPlan->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyBudgetPlanRequest $request, $school_slug)
    {
        $query = BudgetPlan::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
