<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEnvironmentRequest;
use App\Http\Requests\StoreEnvironmentRequest;
use App\Http\Requests\UpdateEnvironmentRequest;
use App\Environment;
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

class EnvironmentController extends Controller
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
        abort_if(Gate::denies('quality_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Environment::query()->select(sprintf('%s.*', (new Environment)->table));
            $query->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year')) {
                $query->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'quality_report_show';
                $editGate = 'quality_report_edit';
                $deleteGate = 'quality_report_delete';
                $crudRoutePart = 'environments';

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

            $table->editColumn('has_file', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->has_file ? 'checked' : null) . '>';
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'has_file', 'file']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->qualityReportsScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->qualityReportsScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->qualityReportsScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.environments.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('quality_report_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        return view('school.environments.create', compact('school_slug'));
    }

    public function store(StoreEnvironmentRequest $request, $school_slug)
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
                'year' => $request->has('year') ? $request->has('year') : date('Y'),
                'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
            ]);
        }
        $request->merge(['school_profile_id' => $schoolProfile['id']]);
        $environment = new Environment($request->all());
        $environment->save();

        if ($request->get('file', false)) {
            try {
                $environment->addMedia(storage_path('tmp/uploads/' . $request->get('file')))->toMediaCollection('file');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($environment) {
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('school.environments.index', ['school_slug' => $school_slug]);

    }

    public function edit($school_slug, Environment $environment)
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileEnvironments', function (Builder $builder) use ($environment) {
                $builder->where('id', $environment['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.environments.edit', compact('school_slug', 'environment'));
    }

    public function update(UpdateEnvironmentRequest $request, $school_slug, Environment $environment)
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileEnvironments', function (Builder $builder) use ($environment) {
                $builder->where('id', $environment['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $environment->update($request->all());

        if ($request->get('file', false)) {
            if (!$environment->file || $request->get('file') !== $environment->file->file_name) {
                try {
                    $environment->addMedia(storage_path('tmp/uploads/' . $request->get('file')))->toMediaCollection('file');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($environment->file) {
            $environment->file->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.environments.index', ['school_slug' => $school_slug]);

    }

    public function show($school_slug, Environment $environment)
    {
        abort_if(Gate::denies('quality_report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileQualityReports', function (Builder $builder) use ($environment) {
                $builder->where('id', $environment['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.environments.show', compact('school_slug', 'qualityReport'));
    }

    /**
     * @param $school_slug
     * @param Environment $environment
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Environment $environment)
    {
        abort_if(Gate::denies('quality_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileEnvironments', function (Builder $builder) use ($environment) {
                $builder->where('id', $environment['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $environment->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }else{
            session()->flash('message', 'EDS LH tidak dapat dihapus karena berkaitan dengan data IPMLH');
        }

        return back();

    }

    public function massDestroy(MassDestroyQualityReportRequest $request, $school_slug)
    {
        $query = Environment::query()->whereIn('id', $request->get('ids'));
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
