<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CadreController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('cadre_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Cadre::with(['work_group', 'work_group.work_group_name', 'work_group.school_profile.school', 'user'])->select(sprintf('%s.*', (new Cadre)->table));

            if ($request->get('school_id')) {
                $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year')) {
                $query->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'cadre_show';
                $editGate = 'cadre_edit';
                $deleteGate = 'cadre_delete';
                $crudRoutePart = 'cadres';

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

            $table->editColumn('work_group_school_profile_school_name', function ($row) {
                return $row->work_group->school_profile->school ? $row->work_group->school_profile->school->name : "";
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

            return $table->make(true);
        }

        return view('admin.cadres.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cadre_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

        $classes = [];

        return view('admin.cadres.create', compact('schools', 'workGroups', 'classes'));
    }

    public function store(StoreCadreRequest $request)
    {

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'username' => strtolower($request->get('username')),
            'password' => Hash::make($request->get('password')),
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
            return redirect()->route('admin.cadres.create');
        } else {
            return redirect()->route('admin.cadres.index');
        }
    }

    public function edit(Request $request, Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

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

        return view('admin.cadres.edit', compact('schools', 'workGroups', 'classes', 'cadre'));
    }

    public function update(UpdateCadreRequest $request, Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $update = $cadre->update($request->all());
        $cadre->user()->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'username' => strtolower($request->get('username')),
        ]);

        if ($request->get('password')) {
            $cadre->user()->update([
                'password' => Hash::make($request->get('password')),
            ]);
        }

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

        return redirect()->route('admin.cadres.index');
    }

    public function show(Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cadres.show', compact( 'cadre'));
    }

    /**
     * @param Cadre $cadre
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Cadre $cadre)
    {
        abort_if(Gate::denies('cadre_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $cadre->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();
    }

    public function massDestroy(MassDestroyCadreRequest $request)
    {
        $queryCadre = Cadre::query()->whereIn('id', $request->get('ids'));
        $items = $queryCadre->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
