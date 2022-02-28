<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\School;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function data(Request $request)
    {
        $querySchool = School::query()
//            ->with('city')
            ->select('id', 'name', 'slug', 'city_id');
        if ($request->get('city')) {
            $querySchool->whereHas('city', function (Builder $builder) use ($request) {
                $builder->where('code', $request->get('city'));
            });
        }
        if ($request->get('level')) {
            $querySchool->where('level', $request->get('level'));
        }
        $query = $querySchool;
        $table = Datatables::of($query);

        $table->addIndexColumn();

        $table->addColumn('status', function ($row) use ($request) {
            $schoolProfile = $row
                ->schoolSchoolProfiles()
                ->where('year', $request->get('year', date('Y')))
                ->first();
            if (!$schoolProfile) {
                $schoolProfile = $row
                    ->schoolSchoolProfiles()
                    ->where('year', '<', $request->get('year', date('Y')))
                    ->orderBy('year', 'desc')
                    ->first();
            }
            return $schoolProfile ? $schoolProfile->environmental_status->name : '';
        });
        $table->editColumn('score', function ($row) use ($request) {
            $schoolProfile = $row
                ->schoolSchoolProfiles()
                ->where('year', $request->get('year', date('Y')))
                ->first();
            if (!$schoolProfile) {
                $schoolProfile = $row
                    ->schoolSchoolProfiles()
                    ->where('year', '<', $request->get('year', date('Y')))
                    ->orderBy('year', 'desc')
                    ->first();
            }

            if ($schoolProfile) {
                DB::table('schools')
                    ->where('id','=', $row->id)
                    ->update(['score' => $schoolProfile->score]);
            }

            return $schoolProfile ? $schoolProfile->score : '';
        });
        $table->addColumn('link', function ($row) use ($request) {
            return '<a href="' . url('/' . $row->slug) . '?year=' . $request->get('year', date('Y')) . '">Klik</a>';
        });

        $table->editColumn('id', function ($row) {
            return $row->slug ?? '';
        });

        $table->rawColumns(['link']);

        return $table->make(true);
    }
}
