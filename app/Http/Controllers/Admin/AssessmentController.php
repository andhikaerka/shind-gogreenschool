<?php

namespace App\Http\Controllers\Admin;

use App\Aspect;
use App\Assessment;
use App\Http\Controllers\Controller;
use App\Province;
use App\School;
use App\SchoolProfile;
use App\Study;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AssessmentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $schoolQuery = School::query()
                ->with('schoolSchoolProfiles', 'schoolSchoolProfiles.environmental_status')
                ->select(sprintf('%s.*', (new School)->table));
            if ($request->get('province')) {
                $schoolQuery->whereHas('city.province', function (Builder $builder) {
                    $builder->where('code', \request()->get('province'));
                });
            }
            if ($request->get('city')) {
                $schoolQuery->whereHas('city', function (Builder $builder) {
                    $builder->where('code', \request()->get('city'));
                });
            }
            $query = $schoolQuery;
            $table = Datatables::of($query);

            $table->addIndexColumn();

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('level', function ($row) {
                return $row->level && isset(School::LEVEL_SELECT[$row->level]) ? School::LEVEL_SELECT[$row->level] : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });
            $table->addColumn('environmental_status_name', function ($row) use ($request) {
                $schoolProfile = SchoolProfile::query()
                    ->where('school_id', '=', $row->id)
                    ->where('year', '=', $request->get('year', date('Y')))
                    ->first();
                return $schoolProfile ? ($schoolProfile->environmental_status->name ?? "") : "";
            });
            $table->addColumn('assessment', function ($row) use ($request) {
                $assessment = Assessment::query()
                    ->whereHas('school_profile', function (Builder $builder) use ($row, $request) {
                        $builder
                            ->where('school_id', '=', $row->id)
                            ->where('year', '=', $request->get('year', date('Y')));
                    })
                    ->first();

                if ($assessment) {
                    return '<a href="' . route("school.assessments.index", ['school_slug' => $row->slug, 'year' => $request->get('year', date('Y'))]) . '">Nilai</a>';
                } else {
                    return '<a href="' . route("school.assessments.index", ['school_slug' => $row->slug, 'year' => $request->get('year', date('Y'))]) . '">Belum Nilai</a>';
                }
            });
            $table->addColumn('actions', function ($row) use ($request) {
                $assessment = Assessment::query()
                    ->whereHas('school_profile', function (Builder $builder) use ($row, $request) {
                        $builder
                            ->where('school_id', '=', $row->id)
                            ->where('year', '=', $request->get('year', date('Y')));
                    })
                    ->first();

                return '<a href="' . route("school.assessments.index", ['school_slug' => $row->slug, 'year' => $request->get('year', date('Y'))]) . '">Edit</a>&nbsp;&nbsp;&nbsp;'.
                    '<a href="' . route("school.assessments.index", ['school_slug' => $row->slug, 'year' => $request->get('year', date('Y'))]) . '">Hapus</a>';
            });

            $table->rawColumns(['actions', 'placeholder', 'assessment', 'environmental_status_name']);

            return $table->make(true);
        }

        $provinces = Province::all()->pluck('name', 'code');

        return view('admin.assessments.index', compact('provinces'));
    }
}
