<?php

namespace App\Http\Controllers\Admin;

use App\Aspect;
use App\BudgetPlan;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBudgetPlanRequest;
use App\Http\Requests\StoreBudgetPlanRequest;
use App\Http\Requests\UpdateBudgetPlanRequest;
use App\School;
use App\SchoolProfile;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BudgetPlanController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('budget_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryBudgetPlan = BudgetPlan::query()
                ->with(['school_profile.school', 'snp_category'])
                ->select(sprintf('%s.*', (new BudgetPlan)->table));

            if ($request->get('school_id')) {
                $queryBudgetPlan->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year')) {
                $queryBudgetPlan->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($queryBudgetPlan);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'budget_plan_show';
                $editGate = 'budget_plan_edit';
                $deleteGate = 'budget_plan_delete';
                $crudRoutePart = 'budget-plans';

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

            $table->editColumn('school_profile_school_name', function ($row) {
                return $row->school_profile->school ? $row->school_profile->school->name : "";
            });

            $table->editColumn('aspect_name', function ($row) {
                return $row->aspect ? $row->aspect->name : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('cost', function ($row) {
                return $row->cost ? $row->cost : "";
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

            return $table->make(true);
        }

        return view('admin.budgetPlans.index');
    }

    public function create()
    {
        abort_if(Gate::denies('budget_plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.budgetPlans.create', compact('schools', 'aspects'));
    }

    public function store(StoreBudgetPlanRequest $request)
    {

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC)
            ->where('year', date('Y'))
            ->first();
        if (!$schoolProfile) {
            $latestSchoolProfile = SchoolProfile::query()
                ->where('school_id', auth()->user()->isSTC)
                ->orderBy('year', 'desc')
                ->first();

            $schoolProfile = SchoolProfile::query()->create([
                'school_id' => auth()->user()->isSTC,
                'year' => date('Y'),
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
            return redirect()->route('admin.budget-plans.create');
        } else {
            return redirect()->route('admin.budget-plans.index');
        }
    }

    public function edit(Request $request, BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.budgetPlans.edit', compact('schools', 'budgetPlan', 'aspects'));
    }

    public function update(UpdateBudgetPlanRequest $request, BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $update = $budgetPlan->update($request->all());

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('admin.budget-plans.index');

    }

    public function show(BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.budgetPlans.show', compact('budgetPlan'));
    }

    /**
     * @param BudgetPlan $budgetPlan
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(BudgetPlan $budgetPlan)
    {
        abort_if(Gate::denies('budget_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $budgetPlan->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyBudgetPlanRequest $request)
    {
        $query = BudgetPlan::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
