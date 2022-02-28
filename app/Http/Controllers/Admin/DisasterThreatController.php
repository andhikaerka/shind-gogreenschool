<?php

namespace App\Http\Controllers\Admin;

use App\DisasterThreat;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDisasterThreatRequest;
use App\Http\Requests\StoreDisasterThreatRequest;
use App\Http\Requests\UpdateDisasterThreatRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DisasterThreatController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('disaster_threat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DisasterThreat::query()->select(sprintf('%s.*', (new DisasterThreat)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'disaster_threat_show';
                $editGate = 'disaster_threat_edit';
                $deleteGate = 'disaster_threat_delete';
                $crudRoutePart = 'disaster-threats';

                return view('partials.dataTablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.disasterThreats.index');
    }

    public function create()
    {
        abort_if(Gate::denies('disaster_threat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disasterThreats.create');
    }

    public function store(StoreDisasterThreatRequest $request)
    {
        $disasterThreat = DisasterThreat::query()->create($request->all());

        if ($disasterThreat) {
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('admin.disaster-threats.index');

    }

    public function edit(DisasterThreat $disasterThreat)
    {
        abort_if(Gate::denies('disaster_threat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disasterThreats.edit', compact('disasterThreat'));
    }

    public function update(UpdateDisasterThreatRequest $request, DisasterThreat $disasterThreat)
    {
        $disasterThreat->update($request->all());

        return redirect()->route('admin.disaster-threats.index');

    }

    public function show(DisasterThreat $disasterThreat)
    {
        abort_if(Gate::denies('disaster_threat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disasterThreat->load('threatsDisasters');

        return view('admin.disasterThreats.show', compact('disasterThreat'));
    }

    /**
     * @param DisasterThreat $disasterThreat
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(DisasterThreat $disasterThreat)
    {
        abort_if(Gate::denies('disaster_threat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $disasterThreat->delete();

        return back();

    }

    public function massDestroy(MassDestroyDisasterThreatRequest $request)
    {
        DisasterThreat::query()->whereIn('id', $request->get('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
