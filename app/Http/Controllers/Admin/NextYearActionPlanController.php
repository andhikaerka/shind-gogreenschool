<?php

namespace App\Http\Controllers\Admin;

use App\BudgetPlan;
use App\Disaster;
use App\Http\Controllers\Controller;
use App\Partner;
use App\Study;
use App\WorkProgram;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NextYearActionPlanController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('next_year_action_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disasters = Disaster::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->get();

        $studies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->get();

        $budgetPlans = BudgetPlan::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->get();

        $partners = Partner::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->get();

        $workPrograms = WorkProgram::query()
            ->whereHas('study.work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->get();

        return view('admin.nextYearActionPlans.index', compact( 'school',
            'request',
            'disasters',
            'studies',
            'budgetPlans',
            'partners',
            'workPrograms'
        ));
    }

    public function print(Request $request)
    {
        abort_if(Gate::denies('next_year_action_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->get();

        return view('admin.nextYearActionPlans.print', compact( 'school', 'request', 'studies'));
    }
}
