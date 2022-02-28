<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyInfrastructureRequest;
use App\Http\Requests\StoreInfrastructureRequest;
use App\Http\Requests\UpdateInfrastructureRequest;
use App\Infrastructure;
use App\School;
use App\SchoolProfile;
use App\WorkGroup;
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

class InfrastructureController extends Controller
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
        abort_if(Gate::denies('infrastructure_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Infrastructure::query()->with(['aspect', 'work_group', 'work_group.work_group_name'])->select(sprintf('%s.*', (new Infrastructure)->table));
            $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year')) {
                $query->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'infrastructure_show';
                $editGate = 'infrastructure_edit';
                $deleteGate = 'infrastructure_delete';
                $crudRoutePart = 'infrastructures';

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

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('aspect_name', function ($row) {
                return $row->aspect ? $row->aspect->name : '';
            });
            $table->editColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group->work_group_name ? $row->work_group->work_group_name->name : '') : '';
            });
            $table->editColumn('total', function ($row) {
                return $row->total ? $row->total : "";
            });
            $table->editColumn('function', function ($row) {
                return $row->function ? $row->function : "";
            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'photo']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->infrastructuresScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->infrastructuresScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->infrastructuresScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.infrastructures.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('infrastructure_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.infrastructures.create', compact('school_slug', 'aspects'));
    }

    public function store(StoreInfrastructureRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC)
            ->whereHas('schoolProfileWorkGroups', function($q) use($request){
                $q->where('id', $request->work_group_id);
            })
            ->firstOrFail();
        /* if (!$schoolProfile) {
            $latestSchoolProfile = SchoolProfile::query()
                ->where('school_id', auth()->user()->isSTC)
                ->orderBy('year', 'desc')
                ->first();

            $schoolProfile = SchoolProfile::query()->create([
                'school_id' => auth()->user()->isSTC,
                'year' => date('Y'),
                'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
            ]);
        }

        $request->merge(['school_profile_id' => $schoolProfile['id']]); */
        $infrastructure = new Infrastructure($request->all());
        $infrastructure->save();

        if ($request->get('photo', false)) {
            try {
                $infrastructure->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($infrastructure) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.infrastructures.create', ['school_slug' => $school_slug]);
        } else {
            return redirect()->route('school.infrastructures.index', ['school_slug' => $school_slug, 'year' => $schoolProfile->year]);
        }
    }

    public function edit($school_slug, Infrastructure $infrastructure)
    {
        abort_if(Gate::denies('infrastructure_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInfrastructures', function (Builder $builder) use ($infrastructure) {
                $builder->where('id', $infrastructure['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.infrastructures.edit', compact('school_slug', 'infrastructure', 'aspects'));
    }

    public function update(UpdateInfrastructureRequest $request, $school_slug, Infrastructure $infrastructure)
    {
        abort_if(Gate::denies('infrastructure_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInfrastructures', function (Builder $builder) use ($infrastructure) {
                $builder->where('id', $infrastructure['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $infrastructure->update($request->all());

        if ($request->get('photo', false)) {
            if (!$infrastructure['photo'] || $request->get('photo') !== $infrastructure->photo->file_name) {
                try {
                    $infrastructure->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($infrastructure['photo']) {
            $infrastructure->photo->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.infrastructures.index', ['school_slug' => $school_slug, 'year' => $infrastructure->work_group->school_profile->year]);

    }

    public function show($school_slug, Infrastructure $infrastructure)
    {
        abort_if(Gate::denies('infrastructure_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInfrastructures', function (Builder $builder) use ($infrastructure) {
                $builder->where('id', $infrastructure['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.infrastructures.show', compact('school_slug', 'infrastructure'));
    }

    /**
     * @param $school_slug
     * @param Infrastructure $infrastructure
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Infrastructure $infrastructure)
    {
        abort_if(Gate::denies('infrastructure_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupInfrastructures', function (Builder $builder) use ($infrastructure) {
                $builder->where('id', $infrastructure['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $infrastructure->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyInfrastructureRequest $request, $school_slug)
    {
        $query = Infrastructure::query()->whereIn('id', $request->get('ids'));
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
