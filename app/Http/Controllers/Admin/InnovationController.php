<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class InnovationController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('innovation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Innovation::with(['work_group', 'work_group.work_group_name', 'work_group.aspect', 'team_statuses', 'work_group.school_profile.school'])->select(sprintf('%s.*', (new Innovation)->table));

            if ($request->get('school_id')) {
                $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->has('year')) {
                $query->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'innovation_show';
                $editGate = 'innovation_edit';
                $deleteGate = 'innovation_delete';
                $crudRoutePart = 'innovations';

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

            return $table->make(true);
        }

        return view('admin.innovations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('innovation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        $workGroups = [];

        return view('admin.innovations.create', compact('schools', 'aspects', 'teamStatuses', 'workGroups'));
    }

    public function store(StoreInnovationRequest $request)
    {

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
            return redirect()->route('admin.innovations.create');
        } else {
            return redirect()->route('admin.innovations.index');
        }
    }

    public function edit(Request $request, Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        $workGroups = [];

        return view('admin.innovations.edit', compact('schools', 'aspects', 'teamStatuses', 'workGroups', 'innovation', 'maxPercentage'));
    }

    public function update(UpdateInnovationRequest $request, Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

        return redirect()->route('admin.innovations.index');

    }

    public function show(Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.innovations.show', compact( 'innovation'));
    }

    /**
     * @param Innovation $innovation
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Innovation $innovation)
    {
        abort_if(Gate::denies('innovation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $innovation->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyInnovationRequest $request)
    {
        $query = Innovation::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
