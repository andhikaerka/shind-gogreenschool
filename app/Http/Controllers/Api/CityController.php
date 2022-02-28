<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::query()
            ->select('code as id', 'name as text')
            ->whereHas('province', function (Builder $query) use ($request) {
                $query->where('code', $request->get('province'));
            })
            ->orderBy('name')
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect') . ' ' . trans('crud.school.fields.city')])
            ->toArray();

        return response()->json($cities);
    }
}
