<?php

namespace App\Http\Controllers\School;

use App\Cadre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCadreRequest;
use App\Http\Requests\StoreCadreRequest;
use App\Http\Requests\UpdateCadreRequest;
use App\School;
use App\SchoolProfile;
use App\User;
use App\WorkGroup;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CadreController extends Controller
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
        abort_if(Gate::denies('cadre_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Cadre::with(['work_group', 'work_group.work_group_name', 'work_group.school_profile.school', 'user'])->select(sprintf('%s.*', (new Cadre)->table));
            $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year')) {
                $query->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'cadre_show';
                $editGate = 'cadre_edit';
                $deleteGate = 'cadre_delete';
                $crudRoutePart = 'cadres';

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
            $table->addColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group ? $row->work_group->work_group_name->name : '') : '';
            });
            $table->addColumn('age', function ($row) {
                return !is_null($row->age) ? $row->age : "";
            });

            $table->editColumn('gender', function ($row) {
                return $row->gender ? Cadre::GENDER_SELECT[$row->gender] : '';
            });
            $table->editColumn('class', function ($row) {
                return $row->class ? Cadre::CLASS_SELECT[$row->class] : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : "";
            });

            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });
            $table->editColumn('hobby', function ($row) {
                return $row->hobby ? $row->hobby : "";
            });
            $table->editColumn('position', function ($row) {
                return $row->position ? (isset(Cadre::POSITION_SELECT[$row->position]) ? Cadre::POSITION_SELECT[$row->position] : $row->position) : '';
            });
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return '<a href="' . $photo->url . '" target="_blank"><img src="' . $photo->url . '" width="50px" height="50px" alt=""></a>';
                }

                return '';

            });
            $table->editColumn('letter', function ($row) {
                return $row->letter ? '<a href="' . $row->letter->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'work_group', 'photo', 'letter', 'user']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->cadresScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->cadresScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->cadresScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.cadres.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('cadre_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $school = School::query()->where('slug', $school_slug)->firstOrFail();
        $classes = [];
        if ($school['level'] == 'SD') {
            $classes = [
                ['id' => '1', 'text' => '1'],
                ['id' => '2', 'text' => '2'],
                ['id' => '3', 'text' => '3'],
                ['id' => '4', 'text' => '4'],
                ['id' => '5', 'text' => '5'],
                ['id' => '6', 'text' => '6'],
            ];
        } elseif ($school['level'] == 'SMP') {
            $classes = [
                ['id' => '7', 'text' => '7'],
                ['id' => '8', 'text' => '8'],
                ['id' => '9', 'text' => '9'],
            ];
        } elseif ($school['level'] == 'SMA') {
            $classes = [
                ['id' => '10', 'text' => '10'],
                ['id' => '11', 'text' => '11'],
                ['id' => '12', 'text' => '12'],
            ];
        }

        return view('school.cadres.create', compact('school_slug', 'classes'));
    }

    public function store(StoreCadreRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $user = User::firstOrCreate([
            'email' => $request->get('email'),
        ],
        [
            'name' => $request->get('name'),
            'username' => strtolower($request->get('email')),
            'password' => Hash::make(123456),
            'approved' => true,
        ]);
        $user->save();
        $user->roles()->sync([6]);

        $request->merge(['user_id' => $user['id']]);
        $cadre = Cadre::query()->create($request->all());

        if ($request->get('photo', false)) {
            $cadre->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
        }

        if ($request->get('letter', false)) {
            $cadre->addMedia(storage_path('tmp/uploads/' . $request->get('letter')))->toMediaCollection('letter');
        }

        if ($cadre) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.cadres.create', ['school_slug' => $school_slug, 'year' => $cadre->work_group->school_profile->year]);
        } else {
            return redirect()->route('school.cadres.index', ['school_slug' => $school_slug, 'year' => $cadre->work_group->school_profile->year]);
        }
    }

    public function edit($school_slug, Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupCadres', function (Builder $builder) use ($cadre) {
                $builder->where('id', $cadre['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $workGroupsQuery = WorkGroup::query();
        $workGroupsQuery->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select(['work_groups.id', 'work_group_names.name']);
        $workGroupsQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $school = School::query()->find(auth()->user()->isSTC);
        $classes = [];
        if ($school['level'] == 'SD') {
            $classes = [
                ['id' => '1', 'text' => '1'],
                ['id' => '2', 'text' => '2'],
                ['id' => '3', 'text' => '3'],
                ['id' => '4', 'text' => '4'],
                ['id' => '5', 'text' => '5'],
                ['id' => '6', 'text' => '6'],
            ];
        } elseif ($school['level'] == 'SMP') {
            $classes = [
                ['id' => '7', 'text' => '7'],
                ['id' => '8', 'text' => '8'],
                ['id' => '9', 'text' => '9'],
            ];
        } elseif ($school['level'] == 'SMA') {
            $classes = [
                ['id' => '10', 'text' => '10'],
                ['id' => '11', 'text' => '11'],
                ['id' => '12', 'text' => '12'],
            ];
        }


        return view('school.cadres.edit', compact('school_slug', 'workGroups', 'classes', 'cadre'));
    }

    public function update(UpdateCadreRequest $request, $school_slug, Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupCadres', function (Builder $builder) use ($cadre) {
                $builder->where('id', $cadre['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $cadre->update($request->all());
        $cadre->user()->update([
            'email' => $request->get('email'),
        ]);

        if ($request->get('photo', false)) {
            if (!$cadre->photo || $request->get('photo') !== $cadre->photo->file_name) {
                $cadre->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            }

        } elseif ($cadre->photo) {
            $cadre->photo->delete();
        }

        if ($request->get('letter', false)) {
            if (!$cadre->letter || $request->get('letter') !== $cadre->letter->file_name) {
                $cadre->addMedia(storage_path('tmp/uploads/' . $request->get('letter')))->toMediaCollection('letter');
            }

        } elseif ($cadre->letter) {
            $cadre->letter->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.cadres.index', ['school_slug' => $school_slug, 'year' => $cadre->work_group->school_profile->year]);
    }

    public function show($school_slug, Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupCadres', function (Builder $builder) use ($cadre) {
                $builder->where('id', $cadre['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.cadres.show', compact('school_slug', 'cadre'));
    }

    /**
     * @param $school_slug
     * @param Cadre $cadre
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupCadres', function (Builder $builder) use ($cadre) {
                $builder->where('id', $cadre['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $cadre->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back()->with('school_slug', $school_slug);
    }

    public function massDestroy(MassDestroyCadreRequest $request, $school_slug)
    {
        $queryCadre = Cadre::query()->whereIn('id', $request->get('ids'));
        $queryCadre->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $queryCadre->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
