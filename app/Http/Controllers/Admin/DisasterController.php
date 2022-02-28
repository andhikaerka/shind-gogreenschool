<?php

namespace App\Http\Controllers\Admin;

use App\Disaster;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDisasterRequest;
use App\School;
use App\SchoolProfile;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DisasterController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('disaster_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryDisaster = Disaster::query()->with(['school_profile.school']);

            if ($request->get('school_id')) {
                $queryDisaster->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year')) {
                $queryDisaster->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $query = $queryDisaster->select(sprintf('%s.*', (new Disaster)->table));
            $table = Datatables::of($query);
            /*$table
                ->filterColumn('threats', function ($query, $keyword) {
                    $query->whereHas('threats', function ($query) use ($keyword) {
                        $query->where('name', 'like', '%' . $keyword . '%');
                    });
                });*/

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'disaster_show';
                $editGate = 'disaster_edit';
                $deleteGate = 'disaster_delete';
                $crudRoutePart = 'disasters';

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

            $table->editColumn('school_profile_school_name', function ($row) {
                return $row->school_profile->school ? $row->school_profile->school->name : "";
            });
            $table->editColumn('threat', function ($row) {
                return $row->threat ? $row->threat : "";
            });
            $table->editColumn('potential', function ($row) {
                return $row->potential ? $row->potential : "";
            });
            $table->editColumn('vulnerability', function ($row) {
                return $row->vulnerability ? $row->vulnerability : "";
            });
            $table->editColumn('impact', function ($row) {
                return $row->impact ? $row->impact : "";
            });
            /*$table->addColumn('threats', function ($row) {
                $labels = [];

                foreach ($row->threats as $threat) {
                    array_push($labels, $threat->name);
                }

                return implode(', ', $labels);
            });*/
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'photo']);

            return $table->make(true);
        }

        return view('admin.disasters.index');
    }

    public function create()
    {
        abort_if(Gate::denies('disaster_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $threats = DisasterThreat::all()->pluck('name', 'id');

        return view('admin.disasters.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('disaster_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC)
            ->where('year', date('Y'))
            ->first();
        if (!$schoolProfile) {
            $latestSchoolProfile = SchoolProfile::query()
                ->where('school_id', auth()->user()->isSTC)
                ->orderBy('year', 'desc')
                ->first();

            $schoolProfile = SchoolProfile::query()->create([
                'school_id' => auth()->user()->isSTC,
                'year' => date('Y'),
                'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
            ]);
        }

        /*$threats = [];
        foreach ($request->get('threats') as $item) {
            if (!DisasterThreat::query()->find($item)) {
                $disasterThreat = DisasterThreat::query()->create([
                    'name' => $item
                ]);
                array_push($threats, $disasterThreat['id']);
            } else {
                array_push($threats, $item);
            }
        }
        $request->merge(['threats' => $threats]);*/

        $request->validate([
            'threat' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_THREAT],
            'potential' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_POTENTIAL],
            'anticipation' => ['required', 'string'],
            'vulnerability' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_VULNERABILITY],
            'impact' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_IMPACT],
            // 'threats.*' => ['integer', 'exists:disaster_threats,id'],
            // 'threats' => ['required', 'array'],
        ], [], [
            'threat' => strtolower(trans('crud.disaster.fields.threat')),
            'potential' => strtolower(trans('crud.disaster.fields.potential')),
            'anticipation' => strtolower(trans('crud.disaster.fields.anticipation')),
            'vulnerability' => strtolower(trans('crud.disaster.fields.vulnerability')),
            'impact' => strtolower(trans('crud.disaster.fields.impact')),
            // 'threats.*' => strtolower(trans('crud.disaster.fields.threats')),
            // 'threats' => strtolower(trans('crud.disaster.fields.threats')),
        ]);

        $disaster = new Disaster([
            'school_profile_id' => $schoolProfile['id'],
            'threat' => $request->get('threat'),
            'potential' => $request->get('potential'),
            'vulnerability' => $request->get('vulnerability'),
            'impact' => $request->get('impact'),
        ]);
        $disaster->save();
        // $disaster->threats()->sync($threats);

        if ($request->get('photo', false)) {
            try {
                $disaster->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($disaster) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.disasters.create');
        } else {
            return redirect()->route('admin.disasters.index');
        }

    }

    public function edit(Request $request, Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $threats = DisasterThreat::all()->pluck('name', 'id');

        return view('admin.disasters.edit', compact('schools', 'disaster'));
    }

    public function update(Request $request, Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        /*$threats = [];
        foreach ($request->get('threats') as $item) {
            if (!DisasterThreat::query()->find($item)) {
                $disasterThreat = DisasterThreat::query()->create([
                    'name' => $item
                ]);
                array_push($threats, $disasterThreat['id']);
            } else {
                array_push($threats, $item);
            }
        }
        $request->merge(['threats' => $threats]);*/

        $request->validate([
            'school_id' => [(auth()->user()->isSTC) ? 'nullable' : 'required', 'integer', 'exists:schools,id'],
            'threat' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_THREAT],
            'potential' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_POTENTIAL],
            'anticipation' => ['required', 'string'],
            'vulnerability' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_VULNERABILITY],
            'impact' => ['required', 'string', 'max:' . Disaster::MAX_LENGTH_OF_IMPACT],
            // 'threats.*' => ['integer', 'exists:disaster_threats,id'],
            // 'threats' => ['required', 'array'],
        ], [], [
            'school_id' => strtolower(trans('crud.disaster.fields.school')),
            'threat' => strtolower(trans('crud.disaster.fields.threat')),
            'potential' => strtolower(trans('crud.disaster.fields.potential')),
            'anticipation' => strtolower(trans('crud.disaster.fields.anticipation')),
            'vulnerability' => strtolower(trans('crud.disaster.fields.vulnerability')),
            'impact' => strtolower(trans('crud.disaster.fields.impact')),
            // 'threats.*' => strtolower(trans('crud.disaster.fields.threats')),
            // 'threats' => strtolower(trans('crud.disaster.fields.threats')),
        ]);

        $update = $disaster->update($request->all());
        // $disaster->threats()->sync($request->get('threats', []));

        if ($request->get('photo', false)) {
            if (!$disaster['photo'] || $request->get('photo') !== $disaster->photo->file_name) {
                try {
                    $disaster->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($disaster['photo']) {
            $disaster->photo->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('admin.disasters.index');
    }

    public function show(Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.disasters.show', compact( 'disaster'));
    }

    /**
     * @param Disaster $disaster
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $disaster->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();
    }

    public function massDestroy(MassDestroyDisasterRequest $request)
    {
        $query = Disaster::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
