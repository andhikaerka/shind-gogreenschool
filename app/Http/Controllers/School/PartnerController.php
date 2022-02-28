<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPartnerRequest;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Partner;
use App\PartnerActivity;
use App\PartnerCategory;
use App\School;
use App\SchoolProfile;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PartnerController extends Controller
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
        abort_if(Gate::denies('partner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryPartner = Partner::query()->with('partner_category', 'partner_activity')->select(sprintf('%s.*', (new Partner)->table));
            $queryPartner->whereHas('school_profile.school', function (Builder $builder) use ($school_slug) {
                $builder->where('slug', $school_slug);
            });
            if ($request->get('year')) {
                $queryPartner->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($queryPartner);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) use ($school_slug) {
                $viewGate = 'partner_show';
                $editGate = 'partner_edit';
                $deleteGate = 'partner_delete';
                $crudRoutePart = 'partners';

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
            $table->editColumn('cp_phone', function ($row) {
                return $row->cp_name . ' ' . $row->cp_phone;
            });
            $table->editColumn('partner_category_name', function ($row) {
                return $row->partner_category ? $row->partner_category->name : '';
            });
            $table->editColumn('partner_activity_name', function ($row) {
                return $row->partner_activity ? $row->partner_activity->name : "";
            });

            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? $row->purpose : "";
            });
            $table->editColumn('total_people', function ($row) {
                return $row->total_people ? number_format($row->total_people, 0, ',', '.') : "";
            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'photo']);

            $schoolProfile = SchoolProfile::query()
                ->whereHas('school', function (Builder $builder) use ($school_slug) {
                    $builder->where('slug', $school_slug);
                })
                ->where('year', $request->get('year', date('Y')))
                ->first();

            $table->with([
                'total' => $schoolProfile ? $schoolProfile->partnersScore['total'] : '',
                'score' => $schoolProfile ? $schoolProfile->partnersScore['score'] : '',
                'condition' => $schoolProfile ? $schoolProfile->partnersScore['condition'] : '',
            ]);

            return $table->make(true);
        }

        return view('school.partners.index', compact('school_slug'));
    }

    public function create($school_slug)
    {
        abort_if(Gate::denies('partner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->firstOrFail();

        $partner_categories = PartnerCategory::all()->pluck('name', 'id');
        $partner_activities = PartnerActivity::all()->pluck('name', 'id');

        return view('school.partners.create', compact('school_slug', 'partner_categories', 'partner_activities'));
    }

    public function store(StorePartnerRequest $request, $school_slug)
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

        if (!PartnerActivity::find($request->get('partner_activity_id'))) {
            $partnerActivity = PartnerActivity::query()->create(['name' => $request->get('partner_activity_id')]);

            $request->merge(['partner_activity_id' => $partnerActivity['id']]);
        }

        $request->merge(['school_profile_id' => $schoolProfile['id']]);
        $partner = Partner::query()->create($request->all());

        if ($request->get('photo', false)) {
            $partner->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
        }

        if ($partner) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('school.partners.create', ['school_slug' => $school_slug, 'year' => $request->year]);
        } else {
            return redirect()->route('school.partners.index', ['school_slug' => $school_slug, 'year' => $request->year]);
        }
    }

    public function edit($school_slug, Partner $partner)
    {
        abort_if(Gate::denies('partner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfilePartners', function (Builder $builder) use ($partner) {
                $builder->where('id', $partner['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $partner_categories = PartnerCategory::all()->pluck('name', 'id');
        $partner_activities = PartnerActivity::all()->pluck('name', 'id');

        return view('school.partners.edit', compact('school_slug', 'partner_categories', 'partner_activities', 'partner'));
    }

    public function update(UpdatePartnerRequest $request, $school_slug, Partner $partner)
    {
        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfilePartners', function (Builder $builder) use ($partner) {
                $builder->where('id', $partner['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        if (!PartnerActivity::find($request->get('partner_activity_id'))) {
            $partnerActivity = PartnerActivity::query()->create(['name' => $request->get('partner_activity_id')]);

            $request->merge(['partner_activity_id' => $partnerActivity['id']]);
        }

        $update = $partner->update($request->all());

        if ($request->get('photo', false)) {
            if (!$partner->photo || $request->get('photo') !== $partner->photo->file_name) {
                $partner->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            }

        } elseif ($partner->photo) {
            $partner->photo->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.partners.index', ['school_slug' => $school_slug, 'year' => $partner->school_profile->year]);

    }

    public function show($school_slug, Partner $partner)
    {
        abort_if(Gate::denies('partner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfilePartners', function (Builder $builder) use ($partner) {
                $builder->where('id', $partner['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        return view('school.partners.show', compact('school_slug', 'partner'));
    }

    /**
     * @param $school_slug
     * @param Partner $partner
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($school_slug, Partner $partner)
    {
        abort_if(Gate::denies('partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()
            ->where('slug', $school_slug)
            ->whereHas('schoolSchoolProfiles.schoolProfilePartners', function (Builder $builder) use ($partner) {
                $builder->where('id', $partner['id']);
            })
            ->findOrFail(auth()->user()->isSTC);

        $delete = $partner->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyPartnerRequest $request, $school_slug)
    {
        $query = Partner::query()->whereIn('id', $request->get('ids'));
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
