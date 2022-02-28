<?php

namespace App\Http\Controllers\School;

use App\BudgetPlan;
use App\Disaster;
use App\Http\Controllers\Controller;
use App\Partner;
use App\School;
use App\Study;
use App\WorkProgram;
use App\EnvironmentalIssue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThisYearActionPlanController extends Controller
{
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('this_year_action_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $disasters = Disaster::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->get();

        $globalEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Global')
            ->get();

        $nasionalEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Nasional')
            ->get();

        $daerahEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Daerah')
            ->get();

        $lokalEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Lokal')
            ->get();

        $sampahStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 1);
            })
            ->get();

        $energiStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 2);
            })
            ->get();

        $kehatiStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 3);
            })
            ->get();

        $airStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 4);
            })
            ->get();

        $kantinStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 5);
            })
            ->get();

        /*dd($disasters, $studies, $budgetPlans, $partners, $workPrograms);*/

        return view('school.thisYearActionPlans.index', compact(
            'school_slug',
            'school',
            'disasters',
            'globalEnvironmentalIssues',
            'nasionalEnvironmentalIssues',
            'daerahEnvironmentalIssues',
            'lokalEnvironmentalIssues',
            'sampahStudies',
            'energiStudies',
            'kehatiStudies',
            'airStudies',
            'kantinStudies',
            'request'
        ));
    }

    public function print(Request $request, $school_slug)
    {
        abort_if(Gate::denies('this_year_action_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $disasters = Disaster::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->get();

        $globalEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Global')
            ->get();

        $nasionalEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Nasional')
            ->get();

        $daerahEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Daerah')
            ->get();

        $lokalEnvironmentalIssues = EnvironmentalIssue::query()
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('category', 'Lokal')
            ->get();

        $sampahStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 1);
            })
            ->get();

        $energiStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 2);
            })
            ->get();

        $kehatiStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 3);
            })
            ->get();

        $airStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 4);
            })
            ->get();

        $kantinStudies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('work_group', function (Builder $builder) use ($school_slug) {
                $builder->where('aspect_id', 5);
            })
            ->get();

        return view('school.thisYearActionPlans.print', compact('school_slug', 'school',
            'school_slug',
            'school',
            'disasters',
            'globalEnvironmentalIssues',
            'nasionalEnvironmentalIssues',
            'daerahEnvironmentalIssues',
            'lokalEnvironmentalIssues',
            'sampahStudies',
            'energiStudies',
            'kehatiStudies',
            'airStudies',
            'kantinStudies',
            'request'
        ));
    }
}
