<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyInnovationRequest;
use App\Http\Requests\StoreInnovationRequest;
use App\Http\Requests\UpdateInnovationRequest;
use App\School;
use App\SchoolProfile;
use App\TeamStatus;
use App\WorkGroup;
use App\Innovation;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class InnovationController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param Request $request
     * @param $school_slug
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('innovation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Innovation::with(['work_group', 'work_group.work_group_name', 'work_group.aspect', 'team_statuses'])->select(sprintf('%s.*', (new Innovation)->table));
            $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->has('year')) {
                $query->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'innovation_show';
                $editGate = 'innovation_edit';
                $deleteGate = 'innovation_delete';
                $crudRoutePart = 'innovations';

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
            $table->addColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group->work_group_name ? $row->work_group->work_group_name->name : '') : '';
            });
            $table->addColumn('work_group_aspect_name', function ($row) {
                return $row->work_group ? ($row->work_group->aspect ? $row->work_group->aspect->name : '') : '';
            });

            $table->addColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('activity', function ($row) {
                return $row->activity ? $row->activity : '';
            });
            $table->editColumn('tutor', function ($row) {
                return $row->tutor ? $row->tutor : "";
            });
            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? $row->purpose : "";
            });
            $table->editColumn('advantage', function ($row) {
                return $row->advantage ? $row->advantage : "";
            });
            $table->editColumn('innovation', function ($row) {
                return $row->innovation ? $row->innovation : "";
            });
            $table->editColumn('team_statuses_name', function ($row) {
                $labels = [];

                foreach ($row->team_statuses as $team_status) {
                    $labels[] = sprintf('<span class="label label-info label-many badge badge-info">%s</span>', $team_status->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'work_group', 'photo', 'team_statuses_name']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->innovationsScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->innovationsScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->innovationsScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.innovations.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('innovation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $aspects = Aspect::all()->pluck('name', 'id');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        return view('school.innovations.create', compact('school_slug', 'aspects', 'teamStatuses'));
    }

    public function store(StoreInnovationRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $innovation = new Innovation($request->all());
        $innovation->save();

        if ($request->get('photo', false)) {
            try {
                $innovation->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($innovation) {
            $innovation->team_statuses()->sync($request->get('team_statuses', []));

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.innovations.create', ['school_slug' => $school_slug, 'year' => $innovation->work_group->school_profile->year]);
        } else {
            return redirect()->route('school.innovations.index', ['school_slug' => $school_slug, 'year' => $innovation->work_group->school_profile->year]);
        }
    }

    public function edit($school_slug, Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInnovations', function (Builder $builder) use ($innovation) {
                $builder->where('id', $innovation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $aspects = Aspect::all()->pluck('name', 'id');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        return view('school.innovations.edit', compact('school_slug', 'aspects', 'teamStatuses', 'innovation'));
    }

    public function update(UpdateInnovationRequest $request, $school_slug, Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInnovations', function (Builder $builder) use ($innovation) {
                $builder->where('id', $innovation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $innovation->update($request->all());

        if ($request->get('photo', false)) {
            if (!$innovation->photo || $request->get('photo') !== $innovation->photo->file_name) {
                $innovation->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            }

        } elseif ($innovation->photo) {
            $innovation->photo->delete();
        }

        if ($update) {
            $innovation->team_statuses()->sync($request->get('team_statuses', []));

            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.innovations.index', ['school_slug' => $school_slug, 'year' => $innovation->work_group->school_profile->year]);

    }

    public function show($school_slug, Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInnovations', function (Builder $builder) use ($innovation) {
                $builder->where('id', $innovation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.innovations.show', compact('school_slug', 'innovation'));
    }

    /**
     * @param $school_slug
     * @param Innovation $innovation
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInnovations', function (Builder $builder) use ($innovation) {
                $builder->where('id', $innovation['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $innovation->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyInnovationRequest $request, $school_slug)
    {
        $query = Innovation::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
