<?php

namespace App\Http\Controllers\Admin;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTeamRequest;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\School;
use App\SchoolProfile;
use App\Team;
use App\TeamPosition;
use App\TeamStatus;
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

class TeamController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Team::query()
                ->with(['user', 'team_status', 'work_group.aspect', 'team_position', 'work_group', 'work_group.work_group_name', 'work_group.school_profile.school'])
                ->select(sprintf('%s.*', (new Team)->table));

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
                $viewGate = 'team_show';
                $editGate = 'team_edit';
                $deleteGate = 'team_delete';
                $crudRoutePart = 'teams';

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

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->addColumn('team_status_name', function ($row) {
                return $row->team_status ? $row->team_status->name : '';
            });
            $table->editColumn('gender', function ($row) {
                return $row->gender ? Team::GENDER_SELECT[$row->gender] : '';
            });

            $table->addColumn('work_group_aspect_name', function ($row) {
                return $row->work_group->aspect ? $row->work_group->aspect->name : '';
            });
            $table->addColumn('team_position_name', function ($row) {
                return $row->team_position && $row->team_position_id != 7 ? $row->team_position->name : ($row->another_position ?? '');
            });
            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });
            $table->addColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group->work_group_name ? $row->work_group->work_group_name->name : '') : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'document', 'user']);

            return $table->make(true);
        }

        $schoolProfile = SchoolProfile::query()
            ->whereHas('school', function (Builder $builder) use ($request) {
                $builder->where('id', $request->get('school_id'));
            })
            ->where('year', $request->get('year', date('Y')))
            ->first();

        return view('admin.teams.index', compact( 'schoolProfile'));
    }

    public function create()
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatuses = TeamStatus::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $teamPositions = TeamPosition::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

        return view('admin.teams.create', compact('schools', 'teamStatuses', 'aspects', 'teamPositions', 'workGroups'));
    }

    public function store(StoreTeamRequest $request)
    {

        // $request->merge(['school_id' => auth()->user()->isSTC]);

        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'approved' => true,
        ]);
        // $user->update(['username' => strtolower($request->get('username'))]);
        $user->roles()->sync([5]);

        $request->merge(['user_id' => $user['id']]);
        if ($request->get('team_position_id') != 7) {
            $request->merge(['another_position' => null]);
        }
        $team = Team::query()->create($request->all());

        if ($request->get('document', false)) {
            $team->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
        }

        if ($team) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.teams.create');
        } else {
            return redirect()->route('admin.teams.index');
        }
    }

    public function edit(Request $request, Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatuses = TeamStatus::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $teamPositions = TeamPosition::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $workGroups = [];

        return view('admin.teams.edit', compact('schools', 'team', 'teamStatuses', 'aspects', 'teamPositions', 'workGroups'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->get('team_position_id') != 7) {
            $request->merge(['another_position' => null]);
        }
        $update = $team->update($request->all());
        if ($request->get('password')) {
            $team->user()->update([
                'password' => Hash::make($request->get('password')),
            ]);
        }
        $team->user()->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'username' => strtolower($request->get('username')),
        ]);

        if ($request->get('document', false)) {
            if (!$team->document || $request->get('document') !== $team->document->file_name) {
                $team->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

        } elseif ($team->document) {
            $team->document->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('admin.teams.index');

    }

    public function show(Team $team)
    {
        abort_if(Gate::denies('team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.teams.show', compact( 'team'));
    }

    /**
     * @param Team $team
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Team $team)
    {
        abort_if(Gate::denies('team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $team->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyTeamRequest $request)
    {
        $query = Team::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
