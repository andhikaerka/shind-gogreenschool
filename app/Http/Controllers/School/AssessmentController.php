<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Assessment;
use App\Http\Controllers\Controller;
use App\School;
use App\SchoolProfile;
use App\Study;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssessmentController extends Controller
{
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assessment = Assessment::query()
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->first();

        return view('school.assessments.index', compact('school_slug', 'assessment'));
    }

    public function update(Request $request, $school_slug)
    {
        abort_if(Gate::denies('assessment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!(auth()->user()->isAdmin || auth()->user()->isOperator)) {
            return abort(403);
        }

        $request->validate([
            'year' => ['required', 'date_format:Y'],
            'component_1' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_1_SELECT))],
            'component_2' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_2_SELECT))],
            'component_3' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_3_SELECT))],
            'component_4' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_4_SELECT))],
            'component_5' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_5_SELECT))],
            'component_6' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_6_SELECT))],
            'component_7' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_7_SELECT))],
            'component_8' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_8_SELECT))],
            'component_9' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_9_SELECT))],
            'component_10' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_10_SELECT))],
            'component_11' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_11_SELECT))],
            'component_12' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_12_SELECT))],
            'component_13' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_13_SELECT))],
            'component_14' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_14_SELECT))],
            'component_15' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_15_SELECT))],
            'component_16' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_16_SELECT))],
            'component_17' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_17_SELECT))],
            'component_18' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_18_SELECT))],
            'component_19' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_19_SELECT))],
            'component_20' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_20_SELECT))],
            'component_21' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_21_SELECT))],
            'component_22' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_22_SELECT))],
            'component_23' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_23_SELECT))],
            'component_24' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_24_SELECT))],
            'component_25' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_25_SELECT))],
            'component_26' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_26_SELECT))],
            'component_27' => ['required', 'in:' . join(',', array_keys(Assessment::COMPONENT_27_SELECT))],
        ], [], [
            'component_1' => 'komponen 1',
            'component_2' => 'komponen 2',
            'component_3' => 'komponen 3',
            'component_4' => 'komponen 4',
            'component_5' => 'komponen 5',
            'component_6' => 'komponen 6',
            'component_7' => 'komponen 7',
            'component_8' => 'komponen 8',
            'component_9' => 'komponen 9',
            'component_10' => 'komponen 10',
            'component_11' => 'komponen 11',
            'component_12' => 'komponen 12',
            'component_13' => 'komponen 13',
            'component_14' => 'komponen 14',
            'component_15' => 'komponen 15',
            'component_16' => 'komponen 16',
            'component_17' => 'komponen 17',
            'component_18' => 'komponen 18',
            'component_19' => 'komponen 19',
            'component_20' => 'komponen 20',
            'component_21' => 'komponen 21',
            'component_22' => 'komponen 22',
            'component_23' => 'komponen 23',
            'component_24' => 'komponen 24',
            'component_25' => 'komponen 25',
            'component_26' => 'komponen 26',
            'component_27' => 'komponen 27',
        ]);

        $assessment = Assessment::query()
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->first();

        if (!$assessment) {
            $school = School::query()
                ->where('slug', $school_slug)
                ->firstOrFail();

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();
            if (!$schoolProfile) {
                $latestSchoolProfile = SchoolProfile::query()
                    ->whereHas('school', function (Builder $builder) use ($school_slug) {
                        $builder->where('slug', $school_slug);
                    })
                    ->orderBy('year', 'desc')
                    ->first();

                $schoolProfile = SchoolProfile::query()->create([
                    'school_id' => $school['id'],
                    'year' => $request->get('year', date('Y')),
                    'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                    'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                    'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                    'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                    'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                    'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
                ]);
            }

            $request->merge(['school_profile_id' => $schoolProfile['id']]);
            $assessment = Assessment::query()->create($request->all());

            if ($assessment) {
                session()->flash('message', __('global.is_updated'));
            }
        } else {
            $update = $assessment->update($request->all());

            if ($update) {
                session()->flash('message', __('global.is_updated'));
            }
        }

        return redirect()->route('school.assessments.index', ['school_slug' => $school_slug]);
    }

    public function print(Request $request, $school_slug)
    {
        abort_if(Gate::denies('assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assessment = Assessment::query()
            ->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->whereHas('school_profile', function (Builder $builder) use ($request) {
                $builder->where('year', $request->get('year', date('Y')));
            })
            ->first();

        return view('school.assessments.print', compact('school_slug', 'assessment'));
    }
}
