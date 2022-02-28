<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $partners = Partner::query()
            ->selectRaw("id, CONCAT('" . (trans('crud.partner.fields.name')) . ": ', name, '; " . (trans('crud.partner.fields.phone')) . ": ', phone, '; " . (trans('crud.partner.fields.category')) . ": ', category) AS text")
            ->where('school_id', $request->get('school'))
            ->orderBy('name')
            ->get()
            ->prepend(['id' => '', 'text' => trans('global.pleaseSelect')])
            ->toArray();

        return response()->json($partners);
    }
}
