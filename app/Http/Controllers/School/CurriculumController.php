<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCurriculumRequest;
use App\Http\Requests\StoreCurriculumRequest;
use App\Http\Requests\UpdateCurriculumRequest;
use App\Curriculum;
use App\CurriculumCalendar;
use App\School;
use App\SchoolProfile;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CurriculumController extends Controller
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
        abort_if(Gate::denies('curriculum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Curriculum::with(['calendars'])->select(sprintf('%s.*', (new Curriculum)->table));
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
                $viewGate = 'curriculum_show';
                $editGate = 'curriculum_edit';
                $deleteGate = 'curriculum_delete';
                $crudRoutePart = 'curricula';

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
            $table->editColumn('vision', function ($row) {
                return $row->vision ? $row->vision : "";
            });
            $table->editColumn('mission', function ($row) {
                return $row->mission ? $row->mission : "";
            });
            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? $row->purpose : "";
            });
            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('calendars', function ($row) {
                $labels = [];

                foreach ($row->calendars as $calendar) {
                    $labels[] = sprintf('<span class="label label-info label-many badge badge-info">%s</span>', $calendar->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'syllabus', 'document', 'calendars', 'aspect']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->curriculaScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->curriculaScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->curriculaScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.curricula.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('curriculum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $calendars = CurriculumCalendar::all()->pluck('name', 'id');

        return view('school.curricula.create', compact('school_slug', 'calendars'));
    }

    public function store(StoreCurriculumRequest $request, $school_slug)
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
        $curriculum = Curriculum::query()->create($request->all());
        $curriculum->calendars()->sync($request->get('calendars', []));

        if ($request->get('document', false)) {
            $curriculum->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
        }

        if ($curriculum) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.curricula.create', ['school_slug' => $school_slug, 'year' => $request->year]);
        } else {
            return redirect()->route('school.curricula.index', ['school_slug' => $school_slug, 'year' => $request->year]);
        }
    }

    public function edit($school_slug, Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileCurricula', function (Builder $builder) use ($curriculum) {
                $builder->where('id', $curriculum['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $calendars = CurriculumCalendar::all()->pluck('name', 'id');

        return view('school.curricula.edit', compact('school_slug', 'calendars', 'curriculum'));
    }

    public function update(UpdateCurriculumRequest $request, $school_slug, Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileCurricula', function (Builder $builder) use ($curriculum) {
                $builder->where('id', $curriculum['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $curriculum->update($request->all());
        $curriculum->calendars()->sync($request->get('calendars', []));

        if ($request->get('document', false)) {
            if (!$curriculum->document || $request->get('document') !== $curriculum->document->file_name) {
                $curriculum->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

        } elseif ($curriculum->document) {
            $curriculum->document->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.curricula.index', ['school_slug' => $school_slug, 'year' => $curriculum->school_profile->year]);

    }

    public function show($school_slug, Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileCurricula', function (Builder $builder) use ($curriculum) {
                $builder->where('id', $curriculum['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.curricula.show', compact('school_slug', 'curriculum'));
    }

    /**
     * @param $school_slug
     * @param Curriculum $curriculum
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileCurricula', function (Builder $builder) use ($curriculum) {
                $builder->where('id', $curriculum['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $curriculum->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyCurriculumRequest $request, $school_slug)
    {
        $query = Curriculum::query()->whereIn('id', $request->get('ids'));
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
