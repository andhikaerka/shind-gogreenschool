<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\WorkGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class WorkGroupController extends Controller
{
    public function index(Request $request)
    {
        $workGroupQuery = WorkGroup::query()
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->join('school_profiles', 'work_groups.school_profile_id', '=', 'school_profiles.id')
            ->selectRaw("work_groups.id, CONCAT('" . (trans('crud.schoolProfile.fields.year')) . ": ', school_profiles.year, '; " . (trans('crud.workGroup.fields.name')) . ": ', work_group_names.name, '; " . (trans('crud.workGroup.fields.tutor')) . ": ', work_groups.tutor) AS text, work_groups.tutor");
        $workGroupQuery->whereHas('school_profile.school', function (Builder $builder) use ($request) {
            $builder->where('id', $request->get('school'));
        });
        if ($request->has('aspect')) {
            $workGroupQuery->where('work_groups.aspect_id', $request->get('aspect'));
        }
        if ($request->has('year')) {
            $workGroupQuery->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year'));
            });
        }
        $workGroups = $workGroupQuery
            ->orderBy('work_group_names.name')
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
            ->toArray();

        return response()->json($workGroups);
    }
}
