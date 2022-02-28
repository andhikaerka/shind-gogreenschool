<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\BudgetPlan;
use Illuminate\Http\Request;
use DB;

class BudgetPlanController extends Controller
{
    public function index(Request $request)
    {
        $school_slug = $request->school_slug;
        $aspect_id = $request->aspect_id;
        $BudgetPlansQuery = BudgetPlan::whereHas('school_profile.school', function ($q) use ($school_slug) {
            $q->where('slug', $school_slug);
        })
        ->select(DB::raw("id, CONCAT('Deskripsi : ', description, '; Sumber RAB : ', source, '; RAKS : ', cost) AS text"))
        ->where('aspect_id', $aspect_id);

        if ($request->has('year')) {
            $BudgetPlansQuery->whereHas('school_profile', function ($builder) use ($request) {
                $builder->where('year', $request->get('year'));
            });
        }

        $BudgetPlans = $BudgetPlansQuery->get()
        ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
        ->toArray();

        return response()->json($BudgetPlans);
    }
}
