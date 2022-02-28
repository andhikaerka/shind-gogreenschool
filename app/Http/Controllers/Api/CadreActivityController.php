<?php

namespace App\Http\Controllers\Api;

use App\CadreActivity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CadreActivityController extends Controller
{
    public function index(Request $request)
    {
        $cadreActivityQuery = CadreActivity::query()
            ->join('work_programs', 'cadre_activities.work_program_id', '=', 'work_programs.id')
            ->join('studies', 'work_programs.study_id', '=', 'studies.id')
            ->join('work_groups', 'studies.work_group_id', '=', 'work_groups.id')
            ->join('school_profiles', 'work_groups.school_profile_id', '=', 'school_profiles.id')
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->selectRaw("work_programs.id, CONCAT('" . (trans('crud.schoolProfile.fields.year')) . ": ', school_profiles.year, '; " . (trans('crud.workGroup.fields.name')) . ": ', work_group_names.name, '; Kegiatan: ', work_programs.plan) AS text");
        if ($request->has('work_group')) {
            $cadreActivityQuery->where('studies.work_group_id', $request->get('work_group'));
        }
        if($request->has('school')){
            $cadreActivityQuery->whereHas('work_program.study.work_group.school_profile', function($q) use($request){
                $q->where('school_id', $request->school);
            });
        }
        if($request->has('work_program')){
            $cadreActivityQuery->where('work_program_id', $request->work_program);
        }
        $cadreActivities = $cadreActivityQuery
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
            ->toArray();

        return response()->json($cadreActivities);
    }

    public function show(Request $request)
    {
        $cadreActivityQuery = CadreActivity::query()
            ->join('studies', 'work_programs.study_id', '=', 'studies.id')
            ->join('work_groups', 'studies.work_group_id', '=', 'work_groups.id')
            ->join('school_profiles', 'work_groups.school_profile_id', '=', 'school_profiles.id')
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->selectRaw("work_programs.tutor_1, work_programs.tutor_2, work_programs.tutor_3");
        $cadreActivity = $cadreActivityQuery
            ->find($request->get('work_program'))
            ->toArray();

        return response()->json($cadreActivity);
    }

    public function data(Request $request)
    {
        $cadreActivityQuery = CadreActivity::query()
            ->join('work_programs', 'cadre_activities.work_program_id', '=', 'work_programs.id')
            ->join('studies', 'work_programs.study_id', '=', 'studies.id')
            ->join('work_groups', 'studies.work_group_id', '=', 'work_groups.id')
            ->join('school_profiles', 'work_groups.school_profile_id', '=', 'school_profiles.id')
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id');
        if ($request->has('work_group')) {
            $cadreActivityQuery->where('studies.work_group_id', $request->get('work_group'));
        }
        $cadreActivities = $cadreActivityQuery
            ->get()
            ->toArray();

        return response()->json($cadreActivities);
    }
}
