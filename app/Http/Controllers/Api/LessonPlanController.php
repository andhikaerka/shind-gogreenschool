<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\LessonPlan;
use Illuminate\Http\Request;
use DB;

class LessonPlanController extends Controller
{
    public function index(Request $request)
    {
        $school_slug = $request->school_slug;
        $aspect_id = $request->aspect_id;
        $lessonPlansQuery = LessonPlan::whereHas('school_profile.school', function ($q) use ($school_slug) {
            $q->where('slug', $school_slug);
        })
        ->select(DB::raw("id, CONCAT('Kelas : ', class, '; Mata Pelajaran : ', subject, '; Semester : ', period) AS text"))
        ->where('aspect_id', $aspect_id);

        if ($request->has('year')) {
            $lessonPlansQuery->whereHas('school_profile', function ($builder) use ($request) {
                $builder->where('year', $request->get('year'));
            });
        }

        $lessonPlans = $lessonPlansQuery->get()
        ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
        ->toArray();

        return response()->json($lessonPlans);
    }
}
