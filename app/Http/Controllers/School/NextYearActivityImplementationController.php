<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\School;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NextYearActivityImplementationController extends Controller
{
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('next_year_activity_implementation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school = null;
        $schoolQuery = School::query();
        if ($request->get('school_id')) {
            $school = $schoolQuery->find($request->get('school_id'));
        } else {
            $school = $schoolQuery->where('slug', $school_slug)->firstOrFail();
        }

        return view('school.nextYearActivityImplementations.index', compact('schools', 'school'));
    }
}
