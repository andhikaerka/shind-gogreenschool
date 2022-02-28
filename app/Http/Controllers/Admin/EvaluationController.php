<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Aspect;
use App\Http\Controllers\Controller;
use App\Study;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('evaluation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryActivity = Activity::query();
            $queryActivity->with(['work_group', 'work_group.work_group_name', 'work_group.aspect', 'team_statuses', 'work_group.school_profile.school']);

            if ($request->get('school_id')) {
                $queryActivity->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year', date('Y'))) {
                $queryActivity->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            if ($request->get('work_group_id')) {
                $queryActivity->whereHas('work_group', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('work_group_id'));
                });
            }
            $query = $queryActivity->select(sprintf('%s.*', (new Activity)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'activity_show';
                $editGate = 'activity_edit';
                $deleteGate = 'activity_delete';
                $crudRoutePart = 'activities';

                return view('partials.dataTablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('work_group_school_profile_school_name', function ($row) {
                return $row->work_group->school_profile->school ? $row->work_group->school_profile->school->name : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('activity', function ($row) {
                return $row->activity ? $row->activity : "";
            });
            $table->editColumn('advantage', function ($row) {
                return $row->advantage ? $row->advantage : "";
            });
            $table->editColumn('behavioral', function ($row) {
                return $row->behavioral ? $row->behavioral : "";
            });
            $table->editColumn('physical', function ($row) {
                return $row->physical ? $row->physical : "";
            });
            $table->addColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group->work_group_name ? $row->work_group->work_group_name->name : '') : '';
            });
            $table->addColumn('work_group_aspect_name', function ($row) {
                return $row->work_group ? ($row->work_group->aspect ? $row->work_group->aspect->name : '') : '';
            });
            $table->editColumn('team_statuses_name', function ($row) {
                $labels = [];

                foreach ($row->team_statuses as $team_status) {
                    $labels[] = sprintf('<span class="label label-info label-many badge badge-info">%s</span>', $team_status->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'work_group_work_group_name_name', 'work_group_aspect_name', 'team_statuses_name', 'document']);

            return $table->make(true);
        }

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.evaluations.index', compact( 'school', 'request', 'aspects'));
    }

    public function print(Request $request)
    {
        abort_if(Gate::denies('evaluation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->get();

        return view('admin.evaluations.print', compact( 'school', 'request', 'studies'));
    }
}
