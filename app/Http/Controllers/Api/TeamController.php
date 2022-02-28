<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $teamQuery = Team::query();
        $teamQuery->whereHas('work_group.school_profile.school', function($q) use($request){
            $q->where('id', $request->school_id);
        })
        ->select('id', 'name as text');
        if ($request->has('work_group_id')) {
            $teamQuery->whereHas('work_group.aspect.workGroups', function($q)use($request){
                $q->where('id', $request->work_group_id);
            });
        }
        if ($request->get('type') == 'bendahara') {
            $teamQuery->where('team_position_id', 6);
        }
        $teams = $teamQuery
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
            ->toArray();

        return response()->json($teams);
    }
}
