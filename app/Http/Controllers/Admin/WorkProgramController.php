<?php

namespace App\Http\Controllers\Admin;

use App\Aspect;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWorkProgramRequest;
use App\Http\Requests\StoreWorkProgramRequest;
use App\Http\Requests\UpdateWorkProgramRequest;
use App\School;
use App\SchoolProfile;
use App\WorkGroup;
use App\WorkProgram;
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

class WorkProgramController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('work_program_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WorkProgram::query()
                ->with(['study', 'study.work_group', 'study.work_group.work_group_name', 'study.work_group.aspect', 'study.work_group.school_profile.school'])
                ->select(sprintf('%s.*', (new WorkProgram)->table));

            if ($request->get('school_id')) {
                $query->whereHas('study.work_group.school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->has('year')) {
                $query->whereHas('study.work_group.school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'work_program_show';
                $editGate = 'work_program_edit';
                $deleteGate = 'work_program_delete';
                $crudRoutePart = 'work-programs';

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

            $table->editColumn('study_work_group_school_profile_school_name', function ($row) {
                return $row->study->work_group->school_profile->school ? $row->study->work_group->school_profile->school->name : "";
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
            /*$table->editColumn('activity', function ($row) {
                return $row->activity ? $row->activity : "";
            });*/
            $table->editColumn('featured', function ($row) {
                return $row->featured ? 'ya' : 'tdk';
                //return '<input type="checkbox" disabled ' . ($row->featured ? 'checked' : null) . '>';
            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'work_group', 'study', 'featured', 'photo', 'tutor_1', 'study_activity']);

            return $table->make(true);
        }

        return view('admin.workPrograms.index');
    }

    public function create()
    {
        abort_if(Gate::denies('work_program_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id');

        $workGroups = [];

        $maxPercentage = WorkProgram::MAX_PERCENTAGE;

        return view('admin.workPrograms.create', compact('schools', 'aspects', 'workGroups', 'maxPercentage'));
    }

    public function store(StoreWorkProgramRequest $request)
    {

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
            $workProgram->checklist_templates()->sync($request->get('checklist_templates', []));

            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.work-programs.create');
        } else {
            return redirect()->route('admin.work-programs.index');
        }
    }

    public function edit(Request $request, WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aspects = Aspect::all()->pluck('name', 'id');

        $workGroups = [];

        $maxPercentage = WorkProgram::MAX_PERCENTAGE;

        return view('admin.workPrograms.edit', compact('schools', 'aspects', 'workGroups', 'workProgram', 'maxPercentage'));
    }

    public function update(UpdateWorkProgramRequest $request, WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $update = $workProgram->update($request->all());

        if ($request->get('photo', false)) {
            if (!$workProgram->photo || $request->get('photo') !== $workProgram->photo->file_name) {
                $workProgram->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            }

        } elseif ($workProgram->photo) {
            $workProgram->photo->delete();
        }

        if ($update) {
            $workProgram->checklist_templates()->sync($request->get('checklist_templates', []));

            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('admin.work-programs.index');

    }

    public function show(WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.workPrograms.show', compact( 'workProgram'));
    }

    /**
     * @param WorkProgram $workProgram
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(WorkProgram $workProgram)
    {
        abort_if(Gate::denies('work_program_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $workProgram->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyWorkProgramRequest $request)
    {
        $query = WorkProgram::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
