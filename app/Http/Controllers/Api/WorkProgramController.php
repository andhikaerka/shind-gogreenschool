<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\WorkProgram;
use Illuminate\Http\Request;

class WorkProgramController extends Controller
{
    public function index(Request $request)
    {
        $workProgramQuery = WorkProgram::query()
            ->join('studies', 'work_programs.study_id', '=', 'studies.id')
            ->join('work_groups', 'studies.work_group_id', '=', 'work_groups.id')
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->join('school_profiles', 'work_groups.school_profile_id', '=', 'school_profiles.id')
            ->selectRaw("work_programs.id, CONCAT('Nama Proker: ', work_programs.name, '; " . (trans('crud.schoolProfile.fields.year')) . ": ', school_profiles.year, '; " . (trans('crud.workGroup.fields.name')) . ": ', work_group_names.name, '; " . (trans('crud.workProgram.fields.tutor')) . ": ', work_groups.tutor) AS text");
        if ($request->has('work_group')) {
            $workProgramQuery->where('studies.work_group_id', $request->get('work_group'));
        }
        if ($request->has('work_group_id')) {
            $workProgramQuery->where('studies.work_group_id', $request->get('work_group_id'));
        }
        $workPrograms = $workProgramQuery
            ->orderBy('work_group_names.name')
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
            ->toArray();

        return response()->json($workPrograms);
    }

    public function show(Request $request)
    {
        $workProgramQuery = WorkProgram::query()
            ->join('studies', 'work_programs.study_id', '=', 'studies.id')
            ->join('work_groups', 'studies.work_group_id', '=', 'work_groups.id')
            ->join('school_profiles', 'work_groups.school_profile_id', '=', 'school_profiles.id')
            ->selectRaw("work_programs.tutor_1, work_programs.tutor_2, work_programs.tutor_3");
        $workProgram = $workProgramQuery
            ->find($request->get('work_program'))
            ->toArray();

        return response()->json($workProgram);
    }

    public function getPercentage(Request $request){
        $percentageAmountNow =  WorkProgram::query()
            ->whereHas('study', function ($builder) use ($request) {
                $builder->where('work_group_id', $request->work_group_id)
                ->whereHas('work_group.school_profile.school', function ($builder) use ($request) {
                    $builder->where('slug', $request->school_slug);
                });
            })->sum('percentage');
        $maxPercentage = 100 - $percentageAmountNow;
        return response()->json(['maxPercentage' => $maxPercentage]);
    }
}
