<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Study;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonitoringProgressController extends Controller
{
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('monitoring_progress_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studies = [];
        if ($request->get('date') && $request->get('work_group_id')) {
            $studiesQuery = Study::query()->with('studyWorkPrograms');
            $studiesQuery->where('work_group_id', $request->get('work_group_id'));
            $studiesQuery->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('date', date('Y')));
            });
            $studiesQuery->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            $studies = $studiesQuery->get();
        }

        return view('school.monitoringProgresses.index', compact('school_slug', 'aspects', 'studies'));
    }
}
