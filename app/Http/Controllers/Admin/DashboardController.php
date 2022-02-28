<?php

namespace App\Http\Controllers\Admin;

use App\Innovation;
use App\Province;
use App\School;
use App\SchoolProfile;
use App\WorkProgram;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController
{
    public function index(Request $request)
    {
        if ($request->get('year', date('Y')) > date('Y')) {
            return abort(404);
        }

        $innovationQuery = Innovation::query()->with(['work_group', 'work_group.work_group_name', 'work_group.aspect'])
            ->select(sprintf('%s.*', (new Innovation)->table));
        $innovationQuery->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
            $builder->where('id', $request->get('school_id'));
        })->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
            $builder->where('year', $request->get('year', date('Y')));
        });
        $innovations = $innovationQuery->get();

        $featuredWorkProgramQuery = WorkProgram::query()->with(['study', 'study.work_group', 'study.work_group.work_group_name', 'study.work_group.aspect'])
            ->select(sprintf('%s.*', (new WorkProgram)->table));
        $featuredWorkProgramQuery->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($request) {
            $builder->where('id', $request->get('school_id'));
        })->whereHas('study.work_group.school_profile', function (Builder $builder) use ($request) {
            $builder->where('year', $request->get('year', date('Y')));
        })->where('featured', true);
        $featuredWorkPrograms = $featuredWorkProgramQuery->get();

        $mergedInnovationsAndFeaturedWorkPrograms = $innovations->concat($featuredWorkPrograms);

        $endOfYear = Carbon::create($request->get('year', date('Y')))->endOfYear();
        $activeSchoolCount = School::query()
            ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
            ->where('updated_at', '>', $endOfYear->copy()->subMonths(12)->format('Y-m-d H:i:s'))
            ->count();
        $passiveSchoolCount = School::query()
            ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
            ->where('updated_at', '<', $endOfYear->copy()->subMonths(8)->format('Y-m-d H:i:s'))
            ->count();
        $inactiveSchoolCount = School::query()
            ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
            ->where('updated_at', '<', $endOfYear->copy()->subMonths(4)->format('Y-m-d H:i:s'))
            ->count();

        return view('admin.dashboard', compact(
            'mergedInnovationsAndFeaturedWorkPrograms',
            'activeSchoolCount',
            'inactiveSchoolCount',
            'passiveSchoolCount'
        ));
    }

    public function statistic(Request $request)
    {
        $provinces = Province::all()->pluck('name', 'code');

        $endOfYear = Carbon::create($request->get('year', date('Y')))->endOfYear();

        $activeSchoolCounts = [];
        $passiveSchoolCounts = [];
        $inactiveSchoolCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $activeSchoolCountQuery = School::query()
                ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
                ->where('updated_at', '>', $endOfYear->copy()->subMonths(12)->format('Y-m-d H:i:s'))
                ->whereMonth('updated_at', '=', $i);
            if ($request->get('province')) {
                $activeSchoolCountQuery->whereHas('city.province', function (Builder $builder) {
                    $builder->where('code', \request()->get('province'));
                });
            }
            if ($request->get('city')) {
                $activeSchoolCountQuery->whereHas('city', function (Builder $builder) {
                    $builder->where('code', \request()->get('city'));
                });
            }
            $activeSchoolCount = $activeSchoolCountQuery->count();
            array_push($activeSchoolCounts, $activeSchoolCount);


            $passiveSchoolCountQuery = School::query()
                ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
                ->where('updated_at', '<', $endOfYear->copy()->subMonths(8)->format('Y-m-d H:i:s'))
                ->whereMonth('updated_at', '=', $i);
            if ($request->get('province')) {
                $passiveSchoolCountQuery->whereHas('city.province', function (Builder $builder) {
                    $builder->where('code', \request()->get('province'));
                });
            }
            if ($request->get('city')) {
                $passiveSchoolCountQuery->whereHas('city', function (Builder $builder) {
                    $builder->where('code', \request()->get('city'));
                });
            }
            $passiveSchoolCount = $passiveSchoolCountQuery->count();
            array_push($passiveSchoolCounts, $passiveSchoolCount);


            $inactiveSchoolCountQuery = School::query()
                ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
                ->where('updated_at', '<', $endOfYear->copy()->subMonths(4)->format('Y-m-d H:i:s'))
                ->whereMonth('updated_at', '=', $i);
            if ($request->get('province')) {
                $inactiveSchoolCountQuery->whereHas('city.province', function (Builder $builder) {
                    $builder->where('code', \request()->get('province'));
                });
            }
            if ($request->get('city')) {
                $inactiveSchoolCountQuery->whereHas('city', function (Builder $builder) {
                    $builder->where('code', \request()->get('city'));
                });
            }
            $inactiveSchoolCount = $inactiveSchoolCountQuery->count();
            array_push($inactiveSchoolCounts, $inactiveSchoolCount);
        }

        return view('admin.statistic', compact(
            'provinces',
            'activeSchoolCounts',
            'passiveSchoolCounts',
            'inactiveSchoolCounts'
        ));
    }
}
