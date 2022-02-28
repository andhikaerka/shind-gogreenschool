<?php

namespace App\Http\Controllers\School;

use App\EnvironmentalIssue;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEnvironmentalIssueRequest;
use App\Http\Requests\StoreEnvironmentalIssueRequest;
use App\Http\Requests\UpdateEnvironmentalIssueRequest;
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

class EnvironmentalIssueController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $school_slug)
    {
        abort_if(Gate::denies('environmental_issue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EnvironmentalIssue::query()->select(sprintf('%s.*', (new EnvironmentalIssue)->table));
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
                $viewGate = 'environmental_issue_show';
                $editGate = 'environmental_issue_edit';
                $deleteGate = 'environmental_issue_delete';
                $crudRoutePart = 'environmental-issues';

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

            $table->editColumn('document', function ($row) {
                return $row->document ? '<a href="' . $row->document->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'document']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->environmentalIssueScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->environmentalIssueScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->environmentalIssueScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.environmentalIssue.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('environmental_issue_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        return view('school.environmentalIssue.create', compact('school_slug'));
    }

    public function store(StoreEnvironmentalIssueRequest $request, $school_slug)
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
        $environmentalIssue = new EnvironmentalIssue($request->all());
        $environmentalIssue->save();

        if ($request->get('document', false)) {
            try {
                $environmentalIssue->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
            } catch (DiskDoesNotExist $e) {
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($environmentalIssue) {
            session()->flash('message', __('global.is_created'));
        }

        return redirect()->route('school.environmental-issues.index', ['school_slug' => $school_slug, 'year' => $request->year]);

    }

    public function edit($school_slug, EnvironmentalIssue $environmentalIssue)
    {
        abort_if(Gate::denies('environmental_issue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileEnvironmentalIssues', function (Builder $builder) use ($environmentalIssue) {
                $builder->where('id', $environmentalIssue['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.environmentalIssue.edit', compact('school_slug', 'environmentalIssue'));
    }

    public function update(UpdateEnvironmentalIssueRequest $request, $school_slug, EnvironmentalIssue $environmentalIssue)
    {
        abort_if(Gate::denies('environmental_issue_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileEnvironmentalIssues', function (Builder $builder) use ($environmentalIssue) {
                $builder->where('id', $environmentalIssue['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $update = $environmentalIssue->update($request->all());

        if ($request->get('document', false)) {
            if (!$environmentalIssue->document || $request->get('document') !== $environmentalIssue->document->file_name) {
                try {
                    $environmentalIssue->addMedia(storage_path('tmp/uploads/' . $request->get('document')))->toMediaCollection('document');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($environmentalIssue->document) {
            $environmentalIssue->document->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.environmental-issues.index', ['school_slug' => $school_slug, 'year' => $environmentalIssue->school_profile->year]);

    }

    public function show($school_slug, EnvironmentalIssue $environmentalIssue)
    {

    }

    /**
     * @param $school_slug
     * @param EnvironmentalIssue $environmentalIssue
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, EnvironmentalIssue $environmentalIssue)
    {
        abort_if(Gate::denies('environmental_issue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfileEnvironmentalIssues', function (Builder $builder) use ($environmentalIssue) {
                $builder->where('id', $environmentalIssue['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $environmentalIssue->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyEnvironmentalIssueRequest $request, $school_slug)
    {
        $query = EnvironmentalIssue::query()->whereIn('id', $request->get('ids'));
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
