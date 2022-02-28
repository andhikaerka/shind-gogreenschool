<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('recommendation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryActivity = Activity::query();
            $queryActivity->with(['work_group', 'work_group.work_group_name', 'work_group.aspect', 'team_statuses']);
            $queryActivity->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            });
            if ($request->get('year', date('Y'))) {
                $queryActivity->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $query = $queryActivity->select(sprintf('%s.*', (new Activity)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return '';
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('activity', function ($row) {
                return $row->activity ? $row->activity : "";
            });
            $table->editColumn('recommendation', function ($row) {
                return $row->recommendation ? $row->recommendation : "";
            });

            $table->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.recommendations.index');
    }
}
