<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\CadreActivity;
use App\Http\Controllers\Controller;
use App\School;
use App\Study;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EvaluationController extends Controller
{
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('evaluation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryCadreActivity = CadreActivity::query();
            $queryCadreActivity->with(['work_program', 'work_program.study']);
            $queryCadreActivity->whereHas('work_program.study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year', date('Y'))) {
                $queryCadreActivity->whereHas('work_program.study.work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            if ($request->get('work_group_id')) {
                $queryCadreActivity->whereHas('work_program.study.work_group', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('work_group_id'));
                });
            }
            if ($request->get('aspect_id')) {
                $queryCadreActivity->whereHas('work_program.study.work_group', function (Builder $builder) use ($request) {
                    $builder->where('aspect_id', $request->get('aspect_id'));
                });
            }
            $query = $queryCadreActivity->select(sprintf('%s.*', (new CadreActivity)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'activity_show';
                $editGate = 'activity_edit';
                $deleteGate = 'activity_delete';
                $crudRoutePart = 'activities';

                return view('partials.dataTablesActions-school', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'school_slug'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('work_program_name', function ($row) {
                return $row->work_program ? $row->work_program->name : "";
            });
            $table->editColumn('work_program_study_behavioral', function ($row) {
                return $row->work_program ? ($row->work_program->study ? $row->work_program->study->behavioral : "") : "";
            });
            $table->editColumn('work_program_study_physical', function ($row) {
                return $row->work_program ? ($row->work_program->study ? $row->work_program->study->physical : "") : "";
            });
            $table->editColumn('behavioral', function ($row) {
                return $row->behavioral ? $row->behavioral : "";
            });
            $table->editColumn('physical', function ($row) {
                return $row->physical ? $row->physical : "";
            });
            $table->editColumn('percentage', function ($row) {
                return $row->percentage ? $row->percentage . "%" : "";
            });
            $table->editColumn('problem', function ($row) {
                return $row->problem ? $row->problem : "";
            });
            $table->editColumn('plan', function ($row) {
                return $row->plan ? $row->plan : "";
            });
            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'document']);

            return $table->make(true);
        }

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.evaluations.index', compact('school_slug', 'school', 'request', 'aspects'));
    }

    public function print(Request $request, $school_slug)
    {
        abort_if(Gate::denies('evaluation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $studies = Study::query()
            ->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->get();

        return view('school.evaluations.print', compact('school_slug', 'school', 'request', 'studies'));
    }
}
