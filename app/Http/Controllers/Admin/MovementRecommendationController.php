<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovementRecommendationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('movement-recommendation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.movementRecommendations.index');
    }
}
