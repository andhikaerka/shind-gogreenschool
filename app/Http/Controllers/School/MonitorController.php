<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Monitor;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMonitorRequest;
use App\Http\Requests\StoreMonitorRequest;
use App\Http\Requests\UpdateMonitorRequest;
use App\Partner;
use App\School;
use App\SchoolProfile;
use App\TeamStatus;
use App\WorkGroup;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MonitorController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param Request $request
     * @param $school_slug
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('monitor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryMonitor = Monitor::query();
            $queryMonitor->with([
                'work_group', 'work_group.aspect', 'work_group.work_group_name',
                'work_group.workGroupStudies',
                'work_group.workGroupStudies.studyWorkPrograms',
                'work_group.workGroupStudies.studyWorkPrograms.workProgramCadreActivities'
            ]);
            $queryMonitor->whereHas('work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year', date('Y'))) {
                $queryMonitor->whereHas('work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $query = $queryMonitor->select(sprintf('%s.*', (new Monitor)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'monitor_show';
                $editGate = 'monitor_edit';
                $deleteGate = 'monitor_delete';
                $crudRoutePart = 'monitors';

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
            $table->editColumn('work_group_aspect_name', function ($row) {
                return $row->work_group ? ($row->work_group->aspect ? $row->work_group->aspect->name : "") : "";
            });
            $table->editColumn('work_group_work_group_name_name', function ($row) {
                return $row->work_group ? ($row->work_group->work_group_name ? $row->work_group->work_group_name->name : "") : "";
            });
            $table->addColumn('activity', function ($row) {
                $results = '<ol style="padding-inline-start: 20px;">';
                if ($row->work_group) {
                    foreach ($row->work_group->workGroupStudies as $study) {
                        $results .= '<li>';
                        $results .= $study->activities;
                        $results .= '</li>';
                    }
                }
                $results .= '</ol>';

                return $results;
            });
            $table->addColumn('condition', function ($row) {
                $results = '<ol style="padding-inline-start: 20px;">';
                if ($row->work_group) {
                    foreach ($row->work_group->workGroupStudies as $study) {
                        foreach ($study->studyWorkPrograms as $workProgram) {
                            $results .= '<li>';
                            $results .= $workProgram->condition;
                            $results .= '</li>';
                        }
                    }
                }
                $results .= '</ol>';

                return $results;
            });
            $table->addColumn('results', function ($row) {
                $results = '<ol style="padding-inline-start: 20px;">';
                if ($row->work_group) {
                    foreach ($row->work_group->workGroupStudies as $study) {
                        foreach ($study->studyWorkPrograms as $workProgram) {
                            foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                                $results .= '<li>';
                                $results .= $cadreActivity->results;
                                $results .= '</li>';
                            }
                        }
                    }
                }
                $results .= '</ol>';

                return $results;
            });
            $table->addColumn('problem', function ($row) {
                $results = '<ol style="padding-inline-start: 20px;">';
                if ($row->work_group) {
                    foreach ($row->work_group->workGroupStudies as $study) {
                        foreach ($study->studyWorkPrograms as $workProgram) {
                            foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                                $results .= '<li>';
                                $results .= $cadreActivity->problem;
                                $results .= '</li>';
                            }
                        }
                    }
                }
                $results .= '</ol>';

                return $results;
            });
            $table->addColumn('plan', function ($row) {
                $results = '<ol style="padding-inline-start: 20px;">';
                if ($row->work_group) {
                    foreach ($row->work_group->workGroupStudies as $study) {
                        foreach ($study->studyWorkPrograms as $workProgram) {
                            foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                                $results .= '<li>';
                                $results .= $cadreActivity->plan;
                                $results .= '</li>';
                            }
                        }
                    }
                }
                $results .= '</ol>';

                return $results;
            });
            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->editColumn('team_statuses_name', function ($row) {
                $labels = [];

                foreach ($row->team_statuses as $team_status) {
                    $labels[] = sprintf('<span class="label label-info label-many badge badge-info">%s</span>', $team_status->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns([
                'actions', 'placeholder',
                'work_group_aspect_name', 'work_group_work_group_name_name',
                'activity', 'condition', 'results', 'problem', 'plan',
                'document', 'team_statuses_name'
            ]);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->monitorsScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->monitorsScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->monitorsScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.monitors.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('monitor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        return view('school.monitors.create', compact('school_slug', 'aspects', 'teamStatuses'));
    }

    public function store(StoreMonitorRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $monitor = Monitor::query()->create($request->all());

        if ($monitor) {
            $monitor->team_statuses()->sync($request->get('team_statuses', []));

            if ($request->get('document', false)) {
                $monitor->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.monitors.create', ['school_slug' => $school_slug]);
        } else {
            return redirect()->route('school.monitors.index', ['school_slug' => $school_slug]);
        }
    }

    public function edit($school_slug, Monitor $monitor)
    {
        abort_if(Gate::denies('monitor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupMonitors', function (Builder $builder) use ($monitor) {
                $builder->where('id', $monitor['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $aspects = Aspect::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teamStatusesQuery = TeamStatus::query();
        $teamStatuses = $teamStatusesQuery->pluck('name', 'id');

        return view('school.monitors.edit', compact('school_slug', 'monitor', 'aspects', 'teamStatuses'));
    }

    public function update(UpdateMonitorRequest $request, $school_slug, Monitor $monitor)
    {
        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupMonitors', function (Builder $builder) use ($monitor) {
                $builder->where('id', $monitor['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $monitor->update($request->all());

        if ($request->get('document', false)) {
            if (!$monitor->document || $request->get('document') !== $monitor->document->file_name) {
                $monitor->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            }

        } elseif ($monitor->document) {
            $monitor->document->delete();
        }

        if ($update) {
            $monitor->team_statuses()->sync($request->get('team_statuses', []));

            session()->flash('message', __('global.is_updated'));
        }

        return $request->get('adding_monitors') ? redirect()->route('school.monitors.create', ['school_slug' => $school_slug]) : redirect()->route('school.monitors.index', ['school_slug' => $school_slug]);
    }

    public function show($school_slug, Monitor $monitor)
    {
        abort_if(Gate::denies('monitor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupMonitors', function (Builder $builder) use ($monitor) {
                $builder->where('id', $monitor['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.monitors.show', compact('school_slug', 'monitor'));
    }

    /**
     * @param $school_slug
     * @param Monitor $monitor
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Monitor $monitor)
    {
        abort_if(Gate::denies('monitor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupMonitors', function (Builder $builder) use ($monitor) {
                $builder->where('id', $monitor['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $monitor->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyMonitorRequest $request, $school_slug)
    {
        $query = Monitor::query()->whereIn('id', $request->get('ids'));
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
