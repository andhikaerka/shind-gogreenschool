<?php

namespace App\Http\Controllers\School;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWorkProgramRequest;
use App\Http\Requests\StoreWorkProgramRequest;
use App\Http\Requests\UpdateWorkProgramRequest;
use App\Infrastructure;
use App\School;
use App\SchoolProfile;
use App\WorkGroup;
use App\WorkProgram;
use App\Study;
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

class WorkProgramController extends Controller
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
        abort_if(Gate::denies('work_program_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryWorkProgram = WorkProgram::with(['study', 'study.work_group', 'study.work_group.work_group_name', 'study.work_group.aspect'])->select(sprintf('%s.*', (new WorkProgram)->table));
            $queryWorkProgram->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('work_group_name_id')) {
                $queryWorkProgram->whereHas('study.work_group', function (Builder $builder) use ($request) {
                    $builder->where('work_group_name_id', $request->get('work_group_name_id'));
                });
            }
            if ($request->has('year')) {
                $queryWorkProgram->whereHas('study.work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($queryWorkProgram);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'work_program_show';
                $editGate = 'work_program_edit';
                $deleteGate = 'work_program_delete';
                $crudRoutePart = 'work-programs';

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
            $table->addColumn('study_work_group_work_group_name_name', function ($row) {
                return $row->study ? ($row->study->work_group ? ($row->study->work_group->work_group_name ? $row->study->work_group->work_group_name->name : '') : '') : '';
            });
            $table->addColumn('study_work_group_aspect_name', function ($row) {
                return $row->study ? ($row->study->work_group ? ($row->study->work_group->aspect ? $row->study->work_group->aspect->name : '') : '') : '';
            });

            $table->addColumn('study_potential', function ($row) {
                return $row->study ? $row->study->potential : '';
            });
            $table->addColumn('study_activity', function ($row) {
                return $row->study ? $row->study->activities : '';
            });
            $table->addColumn('study_percentage', function ($row) {
                return $row->study ? ($row->study->percentage . '%') : "";
            });

            $table->editColumn('condition', function ($row) {
                return $row->condition ? $row->condition : "";
            });
            $table->editColumn('plan', function ($row) {
                return $row->plan ? $row->plan : "";
            });
            $table->editColumn('percentage', function ($row) {
                return $row->percentage ? $row->percentage . '%' : "";
            });
            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time . ' Bulan' : "";
            });
            $table->editColumn('tutor_1', function ($row) {
                return $row->tutor ?? '';
            });
            $table->editColumn('featured', function ($row) {
                return $row->featured ? 'ya' : 'tdk';
                // return '<input type="checkbox" disabled ' . ($row->featured ? 'checked' : null) . '>';
            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'work_group', 'study', 'featured', 'photo', 'tutor_1', 'study_activity']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->workProgramsScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->workProgramsScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->workProgramsScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.workPrograms.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('work_program_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', auth()->user()->isSTC)
            ->where('year', date('Y'))
            ->first();

        $study = Study::with([
            'work_group'
        ]);

        $studies = Study::whereHas('work_group', function ($q) use ($schoolProfile) {
            $q->where('school_profile_id', $schoolProfile->id);
        })
        ->with('checklist_templates')
        ->get();

        $list_nama_proker = array();

        foreach ($studies as $key => $study) {
            foreach ($study->checklist_templates()->get() as $checklist_template) {
                array_push(
                    $list_nama_proker,
                    [
                        'value' => $checklist_template->text
                    ]
                );
            }

            array_push(
                $list_nama_proker,
                [
                    'value' => $study->activity
                ]
            );
        }

        $list_nama_proker = array_unique($list_nama_proker, SORT_REGULAR);

        School::query()->where('slug', $school_slug)->firstOrFail();

        $aspects = Aspect::all()->pluck('name', 'id');

        $workGroupsQuery = WorkGroup::query();
        $workGroupsQuery->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select(['work_groups.id', 'work_group_names.name']);
        $workGroupsQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $maxPercentage = 0;

        $tutors_1 = WorkGroup::query()
            ->pluck('tutor', 'tutor')
            ->prepend(trans('global.pleaseSelect'), '');
        $tutors_2 = Infrastructure::query()
            ->whereHas('work_group.school_profile.school', function($q) use($school_slug){
                $q->where('slug', $school_slug);
            })
            ->pluck('pic', 'pic')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('school.workPrograms.create', compact(
            'school_slug',
            'aspects',
            'workGroups',
            'maxPercentage',
            'tutors_1',
            'tutors_2',
            'list_nama_proker'
        ));
    }

    public function store(StoreWorkProgramRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->firstOrFail();

        $workProgram = new WorkProgram($request->all());
        $workProgram->save();

        if ($request->get('photo', false)) {
            try {
                $workProgram->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($workProgram) {
            // $workProgram->checklist_templates()->sync($request->get('checklist_templates', []));

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.work-programs.create', ['school_slug' => $school_slug, 'year' => $workProgram->study->work_group->school_profile->year]);
        } else {
            return redirect()->route('school.work-programs.index', ['school_slug' => $school_slug, 'year' => $workProgram->study->work_group->school_profile->year]);
        }
    }

    public function edit($school_slug, WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms', function (Builder $builder) use ($workProgram) {
                $builder->where('id', $workProgram['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $aspects = Aspect::all()->pluck('name', 'id');

        $workGroupsQuery = WorkGroup::query();
        $workGroupsQuery->join('work_group_names', 'work_groups.work_group_name_id', '=', 'work_group_names.id')
            ->select(['work_groups.id', 'work_group_names.name']);
        $workGroupsQuery->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $workGroups = $workGroupsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tutors_1 = WorkGroup::query()
            ->pluck('tutor', 'tutor')
            ->prepend(trans('global.pleaseSelect'), '');
        $tutors_2 = Infrastructure::query()
            ->whereHas('work_group.school_profile.school', function($q) use($school_slug){
                $q->where('slug', $school_slug);
            })
            ->pluck('pic', 'pic')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('school.workPrograms.edit', compact(
            'school_slug',
            'aspects',
            'workGroups',
            'workProgram',
            'tutors_1',
            'tutors_2'
        ));
    }

    public function update(UpdateWorkProgramRequest $request, $school_slug, WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms', function (Builder $builder) use ($workProgram) {
                $builder->where('id', $workProgram['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $workProgram->update($request->all());

        if ($request->get('photo', false)) {
            if (!$workProgram->photo || $request->get('photo') !== $workProgram->photo->file_name) {
                $workProgram->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            }
        } elseif ($workProgram->photo) {
            $workProgram->photo->delete();
        }

        if ($update) {
            // $workProgram->checklist_templates()->sync($request->get('checklist_templates', []));

            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.work-programs.index', ['school_slug' => $school_slug, 'year' => $workProgram->study->work_group->school_profile->year]);
    }

    public function show($school_slug, WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms', function (Builder $builder) use ($workProgram) {
                $builder->where('id', $workProgram['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.workPrograms.show', compact('school_slug', 'workProgram'));
    }

    /**
     * @param $school_slug
     * @param WorkProgram $workProgram
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileWorkGroups.workGroupStudies.studyWorkPrograms', function (Builder $builder) use ($workProgram) {
                $builder->where('id', $workProgram['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $workProgram->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();
    }

    public function massDestroy(MassDestroyWorkProgramRequest $request, $school_slug)
    {
        $query = WorkProgram::query()->whereIn('id', $request->get('ids'));
        $query->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($school_slug) {
            $builder->where('slug', $school_slug);
        });
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
