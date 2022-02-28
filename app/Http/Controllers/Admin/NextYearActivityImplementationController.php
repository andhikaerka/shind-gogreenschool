<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\School;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NextYearActivityImplementationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('next_year_activity_implementation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school = null;
        $schoolQuery = School::query();
        if ($request->get('school_id')) {
            $school = $schoolQuery->find($request->get('school_id'));
        }

        return view('admin.nextYearActivityImplementations.index', compact('schools', 'school'));
    }
}
