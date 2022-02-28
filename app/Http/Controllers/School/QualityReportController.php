<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQualityReportRequest;
use App\Http\Requests\StoreQualityReportRequest;
use App\Http\Requests\UpdateQualityReportRequest;
use App\QualityReport;
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

class QualityReportController extends Controller
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
            $query = QualityReport::query()->select(sprintf('%s.*', (new QualityReport)->table));
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
                $crudRoutePart = 'quality-reports';

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

            $table->editColumn('has_document', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->has_document ? 'checked' : null) . '>';
            });
            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('waste_management', function ($row) {
                return $row->waste_management ? $row->waste_management : "";
            });
            $table->editColumn('energy_conservation', function ($row) {
                return $row->energy_conservation ? $row->energy_conservation : "";
            });
            $table->editColumn('life_preservation', function ($row) {
                return $row->life_preservation ? $row->life_preservation : "";
            });
            $table->editColumn('water_conservation', function ($row) {
                return $row->water_conservation ? $row->water_conservation : "";
            });
            $table->editColumn('canteen_management', function ($row) {
                return $row->canteen_management ? $row->canteen_management : "";
            });
            $table->editColumn('letter', function ($row) {
                return $row->letter ? '<a href="' . $row->letter->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'has_document', 'document', 'letter']);

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

        return view('school.qualityReports.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('quality_report_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        return view('school.qualityReports.create', compact('school_slug'));
    }

    public function store(StoreQualityReportRequest $request, $school_slug)
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
                'year' => date('Y'),
                'vision' => isset($latestSchoolProfile['vision']) ? $latestSchoolProfile['vision'] : '',
                'environmental_status_id' => isset($latestSchoolProfile['environmental_status_id']) ? $latestSchoolProfile['environmental_status_id'] : 1,
                'total_teachers' => isset($latestSchoolProfile['total_teachers']) ? $latestSchoolProfile['total_teachers'] : 0,
                'total_students' => isset($latestSchoolProfile['total_students']) ? $latestSchoolProfile['total_students'] : 0,
                'total_land_area' => isset($latestSchoolProfile['total_land_area']) ? $latestSchoolProfile['total_land_area'] : 0,
                'total_building_area' => isset($latestSchoolProfile['total_building_area']) ? $latestSchoolProfile['total_building_area'] : 0,
            ]);
        }

        $request->merge(['school_profile_id' => $schoolProfile['id']]);
        $qualityReport = new QualityReport($request->all());
        $qualityReport->save();

        if ($request->get('document', false)) {
            try {
                $qualityReport->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($request->get('letter', false)) {
            try {
                $qualityReport->addMedia(storage_path('tmp/uploads/' . $request->get('letter')))->toMediaCollection('letter');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($qualityReport) {
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('school.quality-reports.index', ['school_slug' => $school_slug]);

    }

    public function edit($school_slug, QualityReport $qualityReport)
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileQualityReports', function (Builder $builder) use ($qualityReport) {
                $builder->where('id', $qualityReport['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.qualityReports.edit', compact('school_slug', 'qualityReport'));
    }

    public function update(UpdateQualityReportRequest $request, $school_slug, QualityReport $qualityReport)
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileQualityReports', function (Builder $builder) use ($qualityReport) {
                $builder->where('id', $qualityReport['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $qualityReport->update($request->all());

        if ($request->get('document', false)) {
            if (!$qualityReport->document || $request->get('document') !== $qualityReport->document->file_name) {
                try {
                    $qualityReport->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($qualityReport->document) {
            $qualityReport->document->delete();
        }

        if ($request->get('letter', false)) {
            if (!$qualityReport->letter || $request->get('letter') !== $qualityReport->letter->file_name) {
                try {
                    $qualityReport->addMedia(storage_path('tmp/uploads/' . $request->get('letter')))->toMediaCollection('letter');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($qualityReport->letter) {
            $qualityReport->letter->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.quality-reports.index', ['school_slug' => $school_slug]);

    }

    public function show($school_slug, QualityReport $qualityReport)
    {
        abort_if(Gate::denies('quality_report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileQualityReports', function (Builder $builder) use ($qualityReport) {
                $builder->where('id', $qualityReport['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.qualityReports.show', compact('school_slug', 'qualityReport'));
    }

    /**
     * @param $school_slug
     * @param QualityReport $qualityReport
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, QualityReport $qualityReport)
    {
        dd(1);
        abort_if(Gate::denies('quality_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileQualityReports', function (Builder $builder) use ($qualityReport) {
                $builder->where('id', $qualityReport['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $qualityReport->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyQualityReportRequest $request, $school_slug)
    {
        $query = QualityReport::query()->whereIn('id', $request->get('ids'));
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
