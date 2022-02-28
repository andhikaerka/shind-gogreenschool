<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLessonPlanRequest;
use App\Http\Requests\StoreLessonPlanRequest;
use App\Http\Requests\UpdateLessonPlanRequest;
use App\LessonPlan;
use App\School;
use App\SchoolProfile;
use App\EnvironmentalIssue;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use DB;

class LessonPlanController extends Controller
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
        abort_if(Gate::denies('lesson_plan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = LessonPlan::with(['aspect'])->select(sprintf('%s.*', (new LessonPlan)->table));
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
                $viewGate = 'lesson_plan_show';
                $editGate = 'lesson_plan_edit';
                $deleteGate = 'lesson_plan_delete';
                $crudRoutePart = 'lesson-plans';

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
            $table->editColumn('environmental_issue', function ($row) {
                return $row->environmentalIssue ? $row->environmentalIssue->potency : '';
            });
            $table->editColumn('syllabus', function ($row) {
                return $row->syllabus ? '<a href="' . $row->syllabus->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('rpp', function ($row) {
                return $row->rpp ? '<a href="' . $row->rpp->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'syllabus', 'rpp', 'aspect', 'environmental_issue']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->lessonPlansScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->lessonPlansScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->lessonPlansScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.lessonPlans.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('lesson_plan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $classes = [];
        $school = School::query()->where('slug', $school_slug)->firstOrFail();
        if ($school['level'] == 'SD') {
            $classes = [
                ['id' => '1', 'text' => '1'],
                ['id' => '2', 'text' => '2'],
                ['id' => '3', 'text' => '3'],
                ['id' => '4', 'text' => '4'],
                ['id' => '5', 'text' => '5'],
                ['id' => '6', 'text' => '6'],
            ];
        } elseif ($school['level'] == 'SMP') {
            $classes = [
                ['id' => '7', 'text' => '7'],
                ['id' => '8', 'text' => '8'],
                ['id' => '9', 'text' => '9'],
            ];
        } elseif ($school['level'] == 'SMA') {
            $classes = [
                ['id' => '10', 'text' => '10'],
                ['id' => '11', 'text' => '11'],
                ['id' => '12', 'text' => '12'],
            ];
        }

        $environmentalIssues = EnvironmentalIssue::query()
            ->join('school_profiles', 'environmental_issues.school_profile_id', '=', 'school_profiles.id')
            ->select(
            DB::raw("CONCAT('Tahun: ',school_profiles.year,'; Kategori: ',category,'; Potensi Isu: ',potency,'; Masalah: ',problem) AS name"),'environmental_issues.id')
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->pluck('name', 'id');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.lessonPlans.create', compact('school_slug', 'classes', 'aspects', 'environmentalIssues'));
    }

    public function store(StoreLessonPlanRequest $request, $school_slug)
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
            return redirect()->route('school.lesson-plans.create', ['school_slug' => $school_slug, 'year' => $request->year]);
        } else {
            return redirect()->route('school.lesson-plans.index', ['school_slug' => $school_slug, 'year' => $request->year]);
        }
    }

    public function edit($school_slug, LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileLessonPlans', function (Builder $builder) use ($lessonPlan) {
                $builder->where('id', $lessonPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

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

        $environmentalIssues = EnvironmentalIssue::query()
            ->join('school_profiles', 'environmental_issues.school_profile_id', '=', 'school_profiles.id')
            ->select(
            DB::raw("CONCAT('Tahun: ',school_profiles.year,'; Kategori: ',category,'; Potensi Isu: ',potency,'; Masalah: ',problem) AS name"),'environmental_issues.id')
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->pluck('name', 'id');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.lessonPlans.edit', compact('school_slug', 'classes', 'aspects', 'lessonPlan', 'environmentalIssues'));
    }

    public function update(UpdateLessonPlanRequest $request, $school_slug, LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileLessonPlans', function (Builder $builder) use ($lessonPlan) {
                $builder->where('id', $lessonPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

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

        return redirect()->route('school.lesson-plans.index', ['school_slug' => $school_slug, 'year' => $lessonPlan->school_profile->year]);

    }

    public function show($school_slug, LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileLessonPlans', function (Builder $builder) use ($lessonPlan) {
                $builder->where('id', $lessonPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.lessonPlans.show', compact('school_slug', 'lessonPlan'));
    }

    /**
     * @param $school_slug
     * @param LessonPlan $lessonPlan
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, LessonPlan $lessonPlan)
    {
        abort_if(Gate::denies('lesson_plan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileLessonPlans', function (Builder $builder) use ($lessonPlan) {
                $builder->where('id', $lessonPlan['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $lessonPlan->delete();

        return back();

    }

    public function massDestroy(MassDestroyLessonPlanRequest $request, $school_slug)
    {
        $query = LessonPlan::query()->whereIn('id', $request->get('ids'));
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
