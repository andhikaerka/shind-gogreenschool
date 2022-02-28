<?php

namespace App\Http\Controllers\School;

use App\Disaster;
use App\DisasterThreat;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDisasterRequest;
use App\School;
use App\SchoolProfile;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DisasterController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param Request $request
     * @param $school_slug
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('disaster_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryDisaster = Disaster::query();
            $queryDisaster->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
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

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'disaster_show';
                $editGate = 'disaster_edit';
                $deleteGate = 'disaster_delete';
                $crudRoutePart = 'disasters';

                return view('partials.dataTablesActions-school', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row',
                    'school_slug'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
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

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->disastersScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->disastersScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->disastersScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.disasters.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('disaster_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        // $threats = DisasterThreat::all()->pluck('name', 'id');

        return view('school.disasters.create', compact('school_slug'));
    }

    public function store(Request $request, $school_slug)
    {
        abort_if(Gate::denies('disaster_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfileQuery = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC);
        if($request->year){
            $schoolProfileQuery->where('year', $request->year);
        }else{
            $schoolProfileQuery->where('year', date('Y'));
        }
        $schoolProfile = $schoolProfileQuery->first();
        if (!$schoolProfile) {
            $latestSchoolProfile = SchoolProfile::query()
                ->where('school_id', auth()->user()->isSTC)
                ->orderBy('year', 'desc')
                ->first();

            $schoolProfile = SchoolProfile::query()->create([
                'school_id' => auth()->user()->isSTC,
                'year' => $request->has('year') ? $request->has('year') : date('Y'),
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
            'anticipation' => $request->get('anticipation'),
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
            return redirect()->route('school.disasters.create', ['school_slug' => $school_slug, 'year' => $request->year]);
        } else {
            return redirect()->route('school.disasters.index', ['school_slug' => $school_slug, 'year' => $request->year]);
        }

    }

    public function edit($school_slug, Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileDisasters', function (Builder $builder) use ($disaster) {
                $builder->where('id', $disaster['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        // $threats = DisasterThreat::all()->pluck('name', 'id');

        return view('school.disasters.edit', compact('school_slug', 'disaster'));
    }

    public function update(Request $request, $school_slug, Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileDisasters', function (Builder $builder) use ($disaster) {
                $builder->where('id', $disaster['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

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

        return redirect()->route('school.disasters.index', ['school_slug' => $school_slug, 'year' => $disaster->school_profile->year]);
    }

    public function show($school_slug, Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileDisasters', function (Builder $builder) use ($disaster) {
                $builder->where('id', $disaster['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.disasters.show', compact('school_slug', 'disaster'));
    }

    /**
     * @param $school_slug
     * @param Disaster $disaster
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Disaster $disaster)
    {
        abort_if(Gate::denies('disaster_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileDisasters', function (Builder $builder) use ($disaster) {
                $builder->where('id', $disaster['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $disaster->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();
    }

    public function massDestroy(MassDestroyDisasterRequest $request, $school_slug)
    {
        $query = Disaster::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
