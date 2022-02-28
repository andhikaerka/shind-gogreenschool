<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = Activity::query()
            ->selectRaw("id, CONCAT('" . (trans('crud.activity.fields.potential')) . ": ', potential, ';
            " . (trans('crud.activity.fields.problem')) . ": ', problem, ';
            " . (trans('crud.activity.fields.activity')) . ": ', activity, ';
            " . (trans('crud.activity.fields.behavioral')) . ": ', behavioral, ';
            " . (trans('crud.activity.fields.physical')) . ": ', physical, ';
            " . (trans('crud.activity.fields.cost')) . ": ', cost) AS text")
            ->whereHas('work_group', function (Builder $builder) use ($request) {
                if ($request->get('school')) {
                    $builder->where('school_id', $request->get('school'));
                }
            })
            ->where('work_group_id', $request->get('work_group'))
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
            ->toArray();

        return response()->json($activities);
    }
}
