<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQualityReportRequest;
use App\Http\Requests\StoreQualityReportRequest;
use App\Http\Requests\UpdateQualityReportRequest;
use App\QualityReport;
use App\School;
use App\SchoolProfile;
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

class QualityReportController extends Controller
{
    use MediaUploadingTrait;
    public function index(Request $request)
    {
        abort_if(Gate::denies('quality_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = QualityReport::query()
                ->with(['school_profile.school'])
                ->select(sprintf('%s.*', (new QualityReport)->table));

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
                $viewGate = 'quality_report_show';
                $editGate = 'quality_report_edit';
                $deleteGate = 'quality_report_delete';
                $crudRoutePart = 'quality-reports';

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

            return $table->make(true);
        }

        return view('admin.qualityReports.index');
    }

    public function create()
    {
        abort_if(Gate::denies('quality_report_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.qualityReports.create');
    }

    public function store(StoreQualityReportRequest $request)
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

        return redirect()->route('admin.quality-reports.index');

    }

    public function edit(Request $request, QualityReport $qualityReport)
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.qualityReports.edit', compact('schools', 'qualityReport'));
    }

    public function update(UpdateQualityReportRequest $request, QualityReport $qualityReport)
    {
        abort_if(Gate::denies('quality_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

        return redirect()->route('admin.quality-reports.index');

    }

    public function show(QualityReport $qualityReport)
    {
        abort_if(Gate::denies('quality_report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.qualityReports.show', compact( 'qualityReport'));
    }

    /**
     * @param QualityReport $qualityReport
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(QualityReport $qualityReport)
    {
        abort_if(Gate::denies('quality_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $qualityReport->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyQualityReportRequest $request)
    {
        $query = QualityReport::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
