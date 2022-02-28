<?php

namespace App\Http\Controllers;

use App\Assessment;
use App\School;
use App\SchoolProfile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        if ($request->get('year', date('Y')) > date('Y')) {
            return abort(404);
        }

        if (url()->previous() == route('login') && auth()->check() && auth()->user()->isAdmin) {
            return redirect()->route('admin.dashboard');
        } elseif (url()->previous() == route('login') && auth()->check() && auth()->user()->isSTC) {
            return redirect()->route('school.dashboard', ['school_slug' => auth()->user()->school_slug]);
        } else {
            return view('home');
        }
    }

    public function school(Request $request, $school_slug)
    {
        if ($request->get('year', date('Y')) > date('Y')) {
            return abort(404);
        }

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        if (auth()->check() && auth()->user() && (auth()->user()->isAdmin || auth()->user()->isOperator || auth()->user()->isSTC)) {
            return redirect()->route('school.dashboard', ['school_slug' => $school_slug]);
        }

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

        $assessment = Assessment::query()
            ->where('school_profile_id', $schoolProfile->id)
            ->first();

        return view('school', compact('school_slug', 'school', 'schoolProfile', 'assessment'));
    }
}
