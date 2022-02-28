<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Environment;
use Illuminate\Http\Request;

class EnvironmentController extends Controller
{
    public function index(Request $request)
    {
        $environments = Environment::query()
            ->selectRaw("id, CONCAT('" . (trans('crud.environment.fields.isi')) . ": ', isi, '; " . (trans('crud.environment.fields.proses')) . ": ', proses) AS text")
            ->where('school_id', $request->get('school'))
            ->where('has_file', true)
            ->get()
            ->prepend([
                'id' => '',
                'text' => trans('global.pleaseSelect')
            ])
            ->toArray();

        return response()->json($environments);
    }
}
