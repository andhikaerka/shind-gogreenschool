<?php

namespace App\Http\Controllers\Admin;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLessonPlanRequest;
use App\Http\Requests\StoreLessonPlanRequest;
use App\Http\Requests\UpdateLessonPlanRequest;
use App\LessonPlan;
use App\School;
use App\SchoolProfile;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LessonPlanController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('lesson_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LessonPlan::with(['aspect', 'school_profile.school'])->select(sprintf('%s.*', (new LessonPlan)->table));
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
                $viewGate = 'lesson_plan_show';
                $editGate = 'lesson_plan_edit';
                $deleteGate = 'lesson_plan_delete';
                $crudRoutePart = 'lesson-plans';

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

            $table->editColumn('subject', function ($row) {
                return $row->subject ? $row->subject : "";
            });
            $table->editColumn('teacher', function ($row) {
                return $row->teacher ? $row->teacher : "";
            });
            $table->editColumn('class', function ($row) {
                return $row->class ? LessonPlan::CLASS_SELECT[$row->class] : '';
            });
            $table->editColumn('aspect_name', function ($row) {
                return $row->aspect ? $row->aspect->name : '';
            });
            $table->editColumn('hook', function ($row) {
                return $row->hook ? $row->hook : "";
            });
            $table->editColumn('artwork', function ($row) {
                return $row->artwork ? $row->artwork : "";
            });
            $table->editColumn('hour', function ($row) {
                return $row->hour ? $row->hour : "";
            });
            $table->editColumn('period', function ($row) {
                return $row->period ? LessonPlan::PERIOD_SELECT[$row->period] : '';
            });
            $table->editColumn('syllabus', function ($row) {
                return $row->syllabus ? '<a href="' . $row->syllabus->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('rpp', function ($row) {
                return $row->rpp ? '<a href="' . $row->rpp->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'syllabus', 'rpp', 'aspect']);

            return $table->make(true);
        }

        return view('admin.lessonPlans.index');
    }

    public function create()
    {
        abort_if(Gate::denies('lesson_plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $classes = [];

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.lessonPlans.create', compact('schools', 'classes', 'aspects'));
    }

    public function store(StoreLessonPlanRequest $request)
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
        $lessonPlan = LessonPlan::query()->create($request->all());

        if ($request->get('syllabus', false)) {
            $lessonPlan->addMedia(storage_path('tmp/uploads/' . $request->get('syllabus')))->toMediaCollection('syllabus');
        }

        if ($request->get('rpp', false)) {
            $lessonPlan->addMedia(storage_path('tmp/uploads/' . $request->get('rpp')))->toMediaCollection('rpp');
        }

        if ($lessonPlan) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.lesson-plans.create');
        } else {
            return redirect()->route('admin.lesson-plans.index');
        }
    }

    public function edit(Request $request, LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $classes = [];

        $schoolsQuery = School::query();
        $schoolsQuery->where('id', auth()->user()->isSTC);

        $school = School::query()->find(auth()->user()->isSTC);
        if ($school->level == 'SD') {
            $classes = [
                ['id' => '1', 'text' => '1'],
                ['id' => '2', 'text' => '2'],
                ['id' => '3', 'text' => '3'],
                ['id' => '4', 'text' => '4'],
                ['id' => '5', 'text' => '5'],
                ['id' => '6', 'text' => '6'],
            ];
        } elseif ($school->level == 'SMP') {
            $classes = [
                ['id' => '7', 'text' => '7'],
                ['id' => '8', 'text' => '8'],
                ['id' => '9', 'text' => '9'],
            ];
        } elseif ($school->level == 'SMA') {
            $classes = [
                ['id' => '10', 'text' => '10'],
                ['id' => '11', 'text' => '11'],
                ['id' => '12', 'text' => '12'],
            ];
        }

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.lessonPlans.edit', compact('schools', 'classes', 'aspects', 'lessonPlan'));
    }

    public function update(UpdateLessonPlanRequest $request, LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessonPlan->update($request->all());

        if ($request->get('syllabus', false)) {
            if (!$lessonPlan->syllabus || $request->get('syllabus') !== $lessonPlan->syllabus->file_name) {
                $lessonPlan->addMedia(storage_path('tmp/uploads/' . $request->get('syllabus')))->toMediaCollection('syllabus');
            }

        } elseif ($lessonPlan->syllabus) {
            $lessonPlan->syllabus->delete();
        }

        if ($request->get('rpp', false)) {
            if (!$lessonPlan->rpp || $request->get('rpp') !== $lessonPlan->rpp->file_name) {
                $lessonPlan->addMedia(storage_path('tmp/uploads/' . $request->get('rpp')))->toMediaCollection('rpp');
            }

        } elseif ($lessonPlan->rpp) {
            $lessonPlan->rpp->delete();
        }

        return redirect()->route('admin.lesson-plans.index');

    }

    public function show(LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lessonPlans.show', compact( 'lessonPlan'));
    }

    /**
     * @param LessonPlan $lessonPlan
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessonPlan->delete();

        return back();

    }

    public function massDestroy(MassDestroyLessonPlanRequest $request)
    {
        $query = LessonPlan::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
