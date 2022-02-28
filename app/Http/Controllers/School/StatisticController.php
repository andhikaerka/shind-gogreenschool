<?php

namespace App\Http\Controllers\School;

use App\Innovation;

use App\AuditLog;
use App\School;
use App\SchoolProfile;
use App\WorkProgram;
use App\Activity;
use App\CadreActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class StatisticController
{
    public function index(Request $request, $school_slug)
    {
        if (!School::query()->where('slug', $school_slug)->exists()) {
            return abort(404);
        }

        if ($request->get('year', date('Y')) > date('Y')) {
            return abort(404);
        }

        $endOfYear = Carbon::create($request->get('year', date('Y')))->endOfYear();

        $activities = [];

        for ($i = 1; $i <= 12; $i++) {
            /* $activityCountQuery = Activity::query()
                ->whereHas('work_group.school_profile.school', function($q)use($school_slug){
                    $q->where('slug', $school_slug);
                })
                ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
                ->where('updated_at', '>', $endOfYear->copy()->subMonths(12)->format('Y-m-d H:i:s'))
                ->whereMonth('updated_at', '=', $i);

            $cadreActivityCountQuery = CadreActivity::query()
                ->whereHas('work_program.study.work_group.school_profile.school', function($q)use($school_slug){
                    $q->where('slug', $school_slug);
                })
                ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
                ->where('updated_at', '>', $endOfYear->copy()->subMonths(12)->format('Y-m-d H:i:s'))
                ->whereMonth('updated_at', '=', $i); */

            $audit = AuditLog::whereHas('user', function($q)use($school_slug){
                $q->whereHas('school', function($q1)use($school_slug){
                    $q1->where('slug', $school_slug);
                })->orWhereHas('team.work_group.school_profile.school', function($q1)use($school_slug){
                    $q1->where('slug', $school_slug);
                })->orWhereHas('cadre.work_group.school_profile.school', function($q1)use($school_slug){
                    $q1->where('slug', $school_slug);
                });
            })
            ->where('created_at', '<=', $endOfYear->copy()->format('Y-m-d H:i:s'))
            ->where('updated_at', '>', $endOfYear->copy()->subMonths(12)->format('Y-m-d H:i:s'))
            ->whereMonth('updated_at', '=', $i)
            ->count();
            array_push($activities, $audit);
/*
            $activityCount = $activityCountQuery->count();
            $cadreActivityCount = $cadreActivityCountQuery->count();
            array_push($activities, $activityCount+$cadreActivityCount); */
        }

        return view('school.statistic', compact('school_slug', 'activities'));
    }
}
