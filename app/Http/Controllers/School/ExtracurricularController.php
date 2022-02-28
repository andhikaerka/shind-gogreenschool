<?php

namespace App\Http\Controllers\School;

use App\Extracurricular;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyExtracurricularRequest;
use App\Http\Requests\StoreExtracurricularRequest;
use App\Http\Requests\UpdateExtracurricularRequest;
use App\School;
use App\SchoolProfile;
use App\TeamStatus;
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

class ExtracurricularController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('extracurricular_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Extracurricular::with('participants')->select(sprintf('%s.*', (new Extracurricular)->table));
            $query->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year')) {
                $query->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'extracurricular_show';
                $editGate = 'extracurricular_edit';
                $deleteGate = 'extracurricular_delete';
                $crudRoutePart = 'extracurriculars';

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

            $table->editColumn('letter', function ($row) {
                return $row->letter ? '<a href="' . $row->letter->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->addColumn('participants', function ($row) {
                $labels = [];

                foreach ($row->participants as $team_status) {
                    array_push($labels, $team_status->name);
                }

                return implode(', ', $labels);
            });

            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'letter', 'document', 'participants']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->selfDevelopmentScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->selfDevelopmentScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->selfDevelopmentScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.extracurricular.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('extracurricular_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();
        $teamStatuses = TeamStatus::pluck('name', 'id');

        return view('school.extracurricular.create', compact('school_slug', 'teamStatuses'));
    }

    public function store(StoreExtracurricularRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfileQuery = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC);
        if($request->year){
            $schoolProfileQuery->where('year', $request->year);
        }else{
            $schoolProfileQuery->where('year', date('Y'));
        }
        $schoolProfile = $schoolProfileQuery->first();
        if (!$schoolProfile) {
            $latestSchoolProfile = SchoolProfile::query()
                ->where('school_id', auth()->user()->isSTC)
                ->orderBy('year', 'desc')
                ->first();

            $schoolProfile = SchoolProfile::query()->create([
                'school_id' => auth()->user()->isSTC,
                'year' => $request->has('year') ? $request->has('year') : date('Y'),
                'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
            ]);
        }
        $request->merge(['school_profile_id' => $schoolProfile['id']]);
        $extracurricular = new Extracurricular($request->all());
        $extracurricular->save();

        if ($request->get('letter', false)) {
            try {
                $extracurricular->addMedia(storage_path('tmp/uploads/' . $request->get('letter')))->toMediaCollection('letter');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($request->get('document', false)) {
            try {
                $extracurricular->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($extracurricular) {
            $extracurricular->participants()->sync($request->get('participants', []));
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('school.extracurriculars.index', ['school_slug' => $school_slug, 'year' => $request->year]);

    }

    public function edit($school_slug, Extracurricular $extracurricular)
    {
        abort_if(Gate::denies('extracurricular_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileEnvironments', function (Builder $builder) use ($extracurricular) {
                $builder->where('id', $extracurricular['id']);
            })
            ->findOrFail(auth()->user()->isSTC);
        $teamStatuses = TeamStatus::pluck('name', 'id');

        return view('school.extracurricular.edit', compact('school_slug', 'extracurricular', 'teamStatuses'));
    }

    public function update(UpdateExtracurricularRequest $request, $school_slug, Extracurricular $extracurricular)
    {
        abort_if(Gate::denies('extracurricular_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileExtracurriculars', function (Builder $builder) use ($extracurricular) {
                $builder->where('id', $extracurricular['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $extracurricular->update($request->all());

        if ($request->get('letter', false)) {
            if (!$extracurricular->letter || $request->get('letter') !== $extracurricular->letter->file_name) {
                try {
                    $extracurricular->addMedia(storage_path('tmp/uploads/' . $request->get('letter')))->toMediaCollection('letter');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($extracurricular->document) {
            $extracurricular->document->delete();
        }

        if ($request->get('document', false)) {
            if (!$extracurricular->document || $request->get('document') !== $extracurricular->document->file_name) {
                try {
                    $extracurricular->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($extracurricular->document) {
            $extracurricular->document->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.extracurriculars.index', ['school_slug' => $school_slug, 'year' => $extracurricular->school_profile->year]);

    }

    public function show($school_slug, Extracurricular $extracurricular)
    {

    }

    /**
     * @param $school_slug
     * @param Extracurricular $extracurricular
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Extracurricular $extracurricular)
    {
        abort_if(Gate::denies('extracurricular_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileExtracurriculars', function (Builder $builder) use ($extracurricular) {
                $builder->where('id', $extracurricular['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $extracurricular->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyExtracurricularRequest $request, $school_slug)
    {
        $query = Extracurricular::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
