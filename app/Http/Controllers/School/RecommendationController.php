<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Recommendation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRecommendationRequest;
use App\Http\Requests\StoreRecommendationRequest;
use App\Http\Requests\UpdateRecommendationRequest;
use App\School;
use App\SchoolProfile;
use App\WorkProgram;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RecommendationController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param Request $request
     * @param $school_slug
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('recommendation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryRecommendation = Recommendation::query();
            $queryRecommendation->with([
                'cadre_activity', 'cadre_activity.work_program'
            ]);
            $queryRecommendation->whereHas('cadre_activity.work_program.study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year', date('Y'))) {
                $queryRecommendation->whereHas('cadre_activity.work_program.study.work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $query = $queryRecommendation->select(sprintf('%s.*', (new Recommendation)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'recommendation_show';
                $editGate = 'recommendation_edit';
                $deleteGate = 'recommendation_delete';
                $crudRoutePart = 'recommendations';

                if (auth()->user()->isAdmin) {
                    if ($row->continue && !$row->pending) {
                        return '<form action="' . route('school.' . $crudRoutePart . '.pending', ['school_slug' => $school_slug, $row->id]) . '" method="POST" onsubmit="return confirm(\'Pending... ' . trans('global.areYouSure') . '\');" style="display: inline-block;">' .
                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                            '<input type="submit" class="btn btn-xs btn-warning" value="Pending">' .
                            '</form>';
                    } else if ($row->pending && !$row->continue) {
                        return '<form action="' . route('school.' . $crudRoutePart . '.continue', ['school_slug' => $school_slug, $row->id]) . '" method="POST" onsubmit="return confirm(\'Lanjut... ' . trans('global.areYouSure') . '\');" style="display: inline-block;">' .
                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                            '<input type="submit" class="btn btn-xs btn-success" value="Lanjut">' .
                            '</form>';
                    } else {
                        return '<form action="' . route('school.' . $crudRoutePart . '.pending', ['school_slug' => $school_slug, $row->id]) . '" method="POST" onsubmit="return confirm(\'Pending... ' . trans('global.areYouSure') . '\');" style="display: inline-block;">' .
                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                            '<input type="submit" class="btn btn-xs btn-warning" value="Pending">' .
                            '</form>' .
                            '<form action="' . route('school.' . $crudRoutePart . '.continue', ['school_slug' => $school_slug, $row->id]) . '" method="POST" onsubmit="return confirm(\'Lanjut... ' . trans('global.areYouSure') . '\');" style="display: inline-block;">' .
                            '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                            '<input type="submit" class="btn btn-xs btn-success" value="Lanjut">' .
                            '</form>';

                    }
                } else {
                    return view('partials.dataTablesActions-school', compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row',
                        'school_slug'
                    ));
                }
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('cadre_activity_work_program_name', function ($row) {
                return $row->cadre_activity ? ($row->cadre_activity->work_program ? $row->cadre_activity->work_program->name : "") : "";
            });
            $table->editColumn('cadre_activity_work_program_plan', function ($row) {
                return $row->cadre_activity ? ($row->cadre_activity->work_program ? $row->cadre_activity->work_program->plan : "") : "";
            });

            $table->rawColumns([
                'actions', 'placeholder',
                'cadre_activity_work_program_name', 'cadre_activity_work_program_plan',
            ]);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->recommendationsScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->recommendationsScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->recommendationsScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.recommendations.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('recommendation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $workPrograms = WorkProgram::query()
            ->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('school.recommendations.create', compact('school_slug', 'workPrograms'));
    }

    public function store(StoreRecommendationRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $recommendation = Recommendation::query()->create($request->all());

        if ($recommendation) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.recommendations.create', ['school_slug' => $school_slug]);
        } else {
            return redirect()->route('school.recommendations.index', ['school_slug' => $school_slug]);
        }
    }

    public function edit($school_slug, Recommendation $recommendation)
    {
        abort_if(Gate::denies('recommendation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities.cadreActivityRecommendations', function (Builder $builder) use ($recommendation) {
                $builder->where('id', $recommendation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $workPrograms = WorkProgram::query()
            ->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('school.recommendations.edit', compact('school_slug', 'recommendation', 'workPrograms'));
    }

    public function update(UpdateRecommendationRequest $request, $school_slug, Recommendation $recommendation)
    {
        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities.cadreActivityRecommendations', function (Builder $builder) use ($recommendation) {
                $builder->where('id', $recommendation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $recommendation->update($request->all());

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return $request->get('adding_recommendations') ? redirect()->route('school.recommendations.create', ['school_slug' => $school_slug]) : redirect()->route('school.recommendations.index', ['school_slug' => $school_slug]);
    }

    public function show($school_slug, Recommendation $recommendation)
    {
        abort_if(Gate::denies('recommendation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities.cadreActivityRecommendations', function (Builder $builder) use ($recommendation) {
                $builder->where('id', $recommendation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.recommendations.show', compact('school_slug', 'recommendation'));
    }

    /**
     * @param $school_slug
     * @param Recommendation $recommendation
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Recommendation $recommendation)
    {
        abort_if(Gate::denies('recommendation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms.workProgramCadreActivities.cadreActivityRecommendations', function (Builder $builder) use ($recommendation) {
                $builder->where('id', $recommendation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $recommendation->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyRecommendationRequest $request, $school_slug)
    {
        $query = Recommendation::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('cadre_activity.work_program.study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function pending($school_slug, Recommendation $recommendation)
    {
        abort_if(Gate::denies('recommendation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!auth()->user()->isAdmin) {
            return abort(404);
        }

        $update = $recommendation->update(['pending' => true, 'continue' => false]);

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return back();

    }

    public function continue($school_slug, Recommendation $recommendation)
    {
        abort_if(Gate::denies('recommendation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!auth()->user()->isAdmin) {
            return abort(404);
        }

        $update = $recommendation->update(['continue' => true, 'pending' => false]);

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return back();

    }
}
