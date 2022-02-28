<?php

namespace App\Http\Controllers\School;

use App\Innovation;
use App\School;
use App\SchoolProfile;
use App\WorkProgram;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController
{
    public function index(Request $request, $school_slug)
    {
        if (!School::query()->where('slug', $school_slug)->exists()) {
            return abort(404);
        }

        if ($request->get('year', date('Y')) > date('Y')) {
            return abort(404);
        }

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', $school['id'])
            ->where('year', $request->get('year', date('Y')))
            ->first();
        if (!$schoolProfile) {
            $lastSchoolProfile = SchoolProfile::query()
                ->where('school_id', $school['id'])
                ->orderBy('year', 'desc')
                ->first();

            $schoolProfile = new SchoolProfile([
                'school_id' => $school['id'],
                'year' => $request->get('year', date('Y')),
                'environmental_status_id' => 1,
                'vision' => $lastSchoolProfile ? $lastSchoolProfile->vision : '',
                'total_teachers' => $lastSchoolProfile ? $lastSchoolProfile->total_teachers : 0,
                'total_students' => $lastSchoolProfile ? $lastSchoolProfile->total_students : 0,
                'total_land_area' => $lastSchoolProfile ? $lastSchoolProfile->total_land_area : 0,
                'total_building_area' => $lastSchoolProfile ? $lastSchoolProfile->total_building_area : 0,
            ]);
            $schoolProfile->save();
        }

        $innovationQuery = Innovation::query()->with(['work_group', 'work_group.work_group_name', 'work_group.aspect'])
            ->select(sprintf('%s.*', (new Innovation)->table));
        $innovationQuery->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        })->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
            $builder->where('year', $request->get('year', date('Y')));
        });
        $innovations = $innovationQuery->get();

        $featuredWorkProgramQuery = WorkProgram::query()->with(['study', 'study.work_group', 'study.work_group.work_group_name', 'study.work_group.aspect'])
            ->select(sprintf('%s.*', (new WorkProgram)->table));
        $featuredWorkProgramQuery->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        })->whereHas('study.work_group.school_profile', function (Builder $builder) use ($request) {
            $builder->where('year', $request->get('year', date('Y')));
        })->where('featured', true);
        $featuredWorkPrograms = $featuredWorkProgramQuery->get();

        $mergedInnovationsAndFeaturedWorkPrograms = $innovations->concat($featuredWorkPrograms);

        $planning = $schoolProfile->planningScore;
        $implementation = $schoolProfile->implementationScore;
        $monev = $schoolProfile->monevScore;

        return view('school.dashboard', compact('school_slug', 'school', 'schoolProfile', 'mergedInnovationsAndFeaturedWorkPrograms', 'planning', 'implementation', 'monev'));
    }
}
