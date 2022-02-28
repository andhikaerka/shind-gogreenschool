<?php

namespace App\Http\Controllers\School;

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
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
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
        abort_if(Gate::denies('team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Team::with(['user', 'team_status', 'work_group.aspect', 'team_position', 'work_group', 'work_group.work_group_name'])->select(sprintf('%s.*', (new Team)->table));
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
                $viewGate = 'team_show';
                $editGate = 'team_edit';
                $deleteGate = 'team_delete';
                $crudRoutePart = 'teams';

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

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->teamsScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->teamsScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->teamsScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        $schoolProfile = SchoolProfile::query()
            ->whereHas('school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            })
            ->where('year', $request->get('year', date('Y')))
            ->first();

        return view('school.teams.index', compact('school_slug', 'schoolProfile'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $teamStatuses = TeamStatus::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $teamPositions = TeamPosition::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $workGroupQuery = WorkGroup::query()
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select('work_groups.id', 'work_group_names.name');
        $workGroupQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupQuery
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('school.teams.create', compact('school_slug', 'teamStatuses', 'aspects', 'teamPositions', 'workGroups'));
    }

    public function store(StoreTeamRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        // $request->merge(['school_id' => auth()->user()->isSTC]);

        $user = User::firstOrCreate([
            'email' => $request->get('email'),
        ],[
            'email' => $request->get('email'),
            'name' => $request->get('name'),
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
            return redirect()->route('school.teams.create', ['school_slug' => $school_slug, 'year' => $team->work_group->school_profile->year]);
        } else {
            return redirect()->route('school.teams.index', ['school_slug' => $school_slug, 'year' => $team->work_group->school_profile->year]);
        }
    }

    public function edit($school_slug, Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupTeams', function (Builder $builder) use ($team) {
                $builder->where('id', $team['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $teamStatuses = TeamStatus::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $teamPositions = TeamPosition::query()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        $workGroupQuery = WorkGroup::query()
            ->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select('work_groups.id', 'work_group_names.name');
        $workGroupQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupQuery
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('school.teams.edit', compact('school_slug', 'team', 'teamStatuses', 'aspects', 'teamPositions', 'workGroups'));
    }

    public function update(UpdateTeamRequest $request, $school_slug, Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupTeams', function (Builder $builder) use ($team) {
                $builder->where('id', $team['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        if ($request->get('team_position_id') != 7) {
            $request->merge(['another_position' => null]);
        }
        $update = $team->update($request->all());

        $user = User::firstOrCreate([
            'email' => $request->get('email'),
        ],[
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'approved' => true,
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

        return redirect()->route('school.teams.index', ['school_slug' => $school_slug, 'year' => $team->work_group->school_profile->year]);

    }

    public function show($school_slug, Team $team)
    {
        abort_if(Gate::denies('team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupTeams', function (Builder $builder) use ($team) {
                $builder->where('id', $team['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.teams.show', compact('school_slug', 'team'));
    }

    /**
     * @param $school_slug
     * @param Team $team
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Team $team)
    {
        abort_if(Gate::denies('team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupTeams', function (Builder $builder) use ($team) {
                $builder->where('id', $team['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $team->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyTeamRequest $request, $school_slug)
    {
        $query = Team::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
