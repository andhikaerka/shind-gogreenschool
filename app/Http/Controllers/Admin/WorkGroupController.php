<?php

namespace App\Http\Controllers\Admin;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWorkGroupRequest;
use App\Http\Requests\StoreWorkGroupRequest;
use App\Http\Requests\UpdateWorkGroupRequest;
use App\Notifications\UserCreated;
use App\School;
use App\SchoolProfile;
use App\User;
use App\WorkGroup;
use App\WorkGroupName;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WorkGroupController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('work_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WorkGroup::query()
                ->with(['user', 'aspect', 'school_profile.school'])
                ->select(sprintf('%s.*', (new WorkGroup)->table));

            if ($request->get('school_id')) {
                $query->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year')) {
                $query->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'work_group_show';
                $editGate = 'work_group_edit';
                $deleteGate = 'work_group_delete';
                $crudRoutePart = 'work-groups';

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

            /*$table->editColumn('year', function ($row) {
                return $row->year ? $row->year : "";
            });*/
            $table->editColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : "";
            });
            $table->editColumn('user_email', function ($row) {
                return $row->user ? $row->user->email : "";
            });
            $table->editColumn('aspect_name', function ($row) {
                return $row->aspect ? $row->aspect->name : "";
            });
            $table->editColumn('tutor', function ($row) {
                return $row->tutor ? $row->tutor : "";
            });
            $table->editColumn('task', function ($row) {
                return $row->task ? $row->task : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'task']);

            return $table->make(true);
        }

        return view('admin.workGroups.index');
    }

    public function create()
    {
        abort_if(Gate::denies('work_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroupNames = WorkGroupName::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.workGroups.create', compact('schools', 'workGroupNames', 'aspects'));
    }

    public function store(StoreWorkGroupRequest $request)
    {

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

        DB::beginTransaction();

        $password = Str::random(8);
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($password),
            'approved' => true,
        ]);
        $user->save();
        $user->update(['username' => strtolower($user->username)]);
        $user->roles()->sync([7]);

        $request->merge(['school_profile_id' => $schoolProfile['id']]);
        $request->merge(['year' => date('Y')]);
        $request->merge(['user_id' => $user['id']]);
        $workGroup = WorkGroup::query()->create($request->all());

        if ($user && $workGroup) {
            DB::commit();

            $user->notify(new UserCreated($password));

            session()->flash('message', __('global.is_created'));
        } else {
            DB::rollBack();
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.work-groups.create');
        } else {
            return redirect()->route('admin.work-groups.index');
        }
    }

    public function edit(Request $request, WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $workGroupNames = WorkGroupName::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.workGroups.edit', compact('schools', 'workGroup', 'workGroupNames', 'aspects'));
    }

    public function update(UpdateWorkGroupRequest $request, WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();

        // $user = User::query()->where('id', $workGroup->work_group_name_id)->firstOrFail();

        /*$userUpdate = $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);*/

        $workGroupUpdate = $workGroup->update($request->all());;

        if ($workGroupUpdate) {
            DB::commit();

            session()->flash('message', __('global.is_created'));
        } else {
            DB::rollBack();
        }

        return redirect()->route('admin.work-groups.index');

    }

    public function show(WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.workGroups.show', compact( 'workGroup'));
    }

    /**
     * @param WorkGroup $workGroup
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();

        // && User::query()->where('id', $workGroup->work_group_name_id)->delete()
        if ($workGroup->delete()) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return back();

    }

    public function massDestroy(MassDestroyWorkGroupRequest $request)
    {
        $query = WorkGroup::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            DB::beginTransaction();

            if ($item->delete() && User::query()->where('id', $item->user_id)->delete()) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
