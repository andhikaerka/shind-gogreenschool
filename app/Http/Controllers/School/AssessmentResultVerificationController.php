<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssessmentResultVerificationController extends Controller
{
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('assessment_result_verification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('school.assessmentResultVerifications.index', compact('school_slug'));
    }
}
