<?php

namespace App\Http\Controllers\School;

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
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WorkGroupController extends Controller
{
    /**
     * @param Request $request
     * @param $school_slug
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('work_group_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WorkGroup::query()->with(['work_group_name', 'aspect'])->select(sprintf('%s.*', (new WorkGroup)->table));
            $query->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year')) {
                $query->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            if(auth()->user()->is_cadre){
                $query->whereHas('workGroupCadres', function (Builder $builder) use ($request) {
                    $builder->where('user_id', auth()->user()->id);
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'work_group_show';
                $editGate = 'work_group_edit';
                $deleteGate = 'work_group_delete';
                $crudRoutePart = 'work-groups';

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

            /*$table->editColumn('year', function ($row) {
                return $row->year ? $row->year : "";
            });*/
            $table->editColumn('work_group_name_name', function ($row) {
                return $row->work_group_name ? ($row->work_group_name_id  ? $row->work_group_name->name : $row->alias) : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
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

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->workGroupsScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->workGroupsScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->workGroupsScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.workGroups.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('work_group_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $workGroupNames = WorkGroupName::whereNotIn('id', [14, 15, 16, 17])
        ->get()
        ->pluck('name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.workGroups.create', compact('school_slug', 'workGroupNames', 'aspects'));
    }

    public function store(StoreWorkGroupRequest $request, $school_slug)
    {
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
                'year' => $request->get('year', date('Y')),
                'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
            ]);
        }

        DB::beginTransaction();

        /*$password = Str::random(8);
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($password),
            'approved' => true,
        ]);
        $user->save();
        $user->update(['username' => strtolower($user->username)]);
        $user->roles()->sync([7]);*/

        $request->merge(['school_profile_id' => $schoolProfile['id']]);
        $request->merge(['year' => $request->get('year', date('Y'))]);
//        $request->merge(['user_id' => $user['id']]);
        $workGroup = WorkGroup::query()->create($request->all());

        if ($workGroup) {
            DB::commit();

//            $user->notify(new UserCreated($password));

            session()->flash('message', __('global.is_created'));
        } else {
            DB::rollBack();
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.work-groups.create', ['school_slug' => $school_slug, 'year' => $request->year]);
        } else {
            return redirect()->route('school.work-groups.index', ['school_slug' => $school_slug, 'year' => $request->year]);
        }
    }

    public function edit($school_slug, WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups', function (Builder $builder) use ($workGroup) {
                $builder->where('id', $workGroup['id']);
            })
            ->findOrFail(auth()->user()->isSTC);


        $workGroupNames = WorkGroupName::whereNotIn('id', [14, 15, 16, 17])
        ->get()
        ->pluck('name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('school.workGroups.edit', compact('school_slug', 'workGroup', 'workGroupNames', 'aspects'));
    }

    public function update(UpdateWorkGroupRequest $request, $school_slug, WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups', function (Builder $builder) use ($workGroup) {
                $builder->where('id', $workGroup['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        DB::beginTransaction();

        /*$user = User::query()->where('id', $workGroup->work_group_name_id)->firstOrFail();

        $userUpdate = $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);*/

        if ($request->get('work_group_name_id')) {
            $request->merge(['alias' => null]);
        }

        $workGroupUpdate = $workGroup->update($request->all());
        ;

        if ($workGroupUpdate) {
            DB::commit();

            session()->flash('message', __('global.is_created'));
        } else {
            DB::rollBack();
        }

        return redirect()->route('school.work-groups.index', ['school_slug' => $school_slug, 'year' => $workGroup->school_profile->year]);
    }

    public function show($school_slug, WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups', function (Builder $builder) use ($workGroup) {
                $builder->where('id', $workGroup['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.workGroups.show', compact('school_slug', 'workGroup'));
    }

    /**
     * @param $school_slug
     * @param WorkGroup $workGroup
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, WorkGroup $workGroup)
    {
        abort_if(Gate::denies('work_group_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups', function (Builder $builder) use ($workGroup) {
                $builder->where('id', $workGroup['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        DB::beginTransaction();
        try {
            $workGroup->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('message', __('Pokja yang sudah memiliki kegiatan tidak dapat dihapus'));
        }
        DB::commit();

        return back();
    }

    public function massDestroy(MassDestroyWorkGroupRequest $request, $school_slug)
    {
        $query = WorkGroup::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
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
