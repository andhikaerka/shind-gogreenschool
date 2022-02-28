<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CurriculumController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('curriculum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Curriculum::with(['calendars', 'school_profile.school'])->select(sprintf('%s.*', (new Curriculum)->table));

            if ($request->get('school_id')) {
                $query->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year')) {
                $query->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'curriculum_show';
                $editGate = 'curriculum_edit';
                $deleteGate = 'curriculum_delete';
                $crudRoutePart = 'curricula';

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

            $table->editColumn('school_profile_school_name', function ($row) {
                return $row->school_profile->school ? $row->school_profile->school->name : "";
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

            return $table->make(true);
        }

        return view('admin.curricula.index');
    }

    public function create()
    {
        abort_if(Gate::denies('curriculum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $calendars = CurriculumCalendar::all()->pluck('name', 'id');

        return view('admin.curricula.create', compact('schools', 'calendars'));
    }

    public function store(StoreCurriculumRequest $request)
    {

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC)
            ->where('year', date('Y'))
            ->first();
        if (!$schoolProfile) {
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
            return redirect()->route('admin.curricula.create');
        } else {
            return redirect()->route('admin.curricula.index');
        }
    }

    public function edit(Request $request, Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $calendars = CurriculumCalendar::all()->pluck('name', 'id');

        return view('admin.curricula.edit', compact('schools', 'calendars', 'curriculum'));
    }

    public function update(UpdateCurriculumRequest $request, Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

        return redirect()->route('admin.curricula.index');

    }

    public function show(Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.curricula.show', compact( 'curriculum'));
    }

    /**
     * @param Curriculum $curriculum
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Curriculum $curriculum)
    {
        abort_if(Gate::denies('curriculum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $curriculum->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyCurriculumRequest $request)
    {
        $query = Curriculum::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
