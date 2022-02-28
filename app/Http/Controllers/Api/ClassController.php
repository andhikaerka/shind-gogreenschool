<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\School;
use App\WorkGroup;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $level = '';

        if ($request->has('school') && $request->get('school')) {
            $school = School::query()->where('id', $request->get('school'))->first();
            $level = $school ? $school->level : '';
        } elseif ($request->has('work_group') && $request->get('work_group')) {
            $workGroup = WorkGroup::query()->where('id', $request->get('work_group'))->first();
            $level = $workGroup ? $workGroup->school->level : '';
        }

        if ($level == 'SD') {
            $classes = [
                ['id' => '', 'text' => trans('global.pleaseSelect')],
                ['id' => '1', 'text' => '1'],
                ['id' => '2', 'text' => '2'],
                ['id' => '3', 'text' => '3'],
                ['id' => '4', 'text' => '4'],
                ['id' => '5', 'text' => '5'],
                ['id' => '6', 'text' => '6'],
            ];
        } elseif ($level == 'SMP') {
            $classes = [
                ['id' => '', 'text' => trans('global.pleaseSelect')],
                ['id' => '7', 'text' => '7'],
                ['id' => '8', 'text' => '8'],
                ['id' => '9', 'text' => '9'],
            ];
        } elseif ($level == 'SMA') {
            $classes = [
                ['id' => '', 'text' => trans('global.pleaseSelect')],
                ['id' => '10', 'text' => '10'],
                ['id' => '11', 'text' => '11'],
                ['id' => '12', 'text' => '12'],
            ];
        } else {
            $classes = [
                ['id' => '', 'text' => trans('global.pleaseSelect')]
            ];
        }

        return response()->json($classes);
    }
}
