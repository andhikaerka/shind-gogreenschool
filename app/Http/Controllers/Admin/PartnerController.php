<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PartnerController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('partner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $queryPartner = Partner::query()
                ->with(['partner_category', 'partner_activity', 'school_profile.school'])->select(sprintf('%s.*', (new Partner)->table));

            if ($request->get('school_id')) {
                $queryPartner->whereHas('school_profile.school', function (Builder $builder) use ($request) {
                    $builder->where('id', $request->get('school_id'));
                });
            }
            if ($request->get('year')) {
                $queryPartner->whereHas('school_profile', function (Builder $builder) use ($request) {
                    $builder->where('year', $request->get('year', date('Y')));
                });
            }
            $table = Datatables::of($queryPartner);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'partner_show';
                $editGate = 'partner_edit';
                $deleteGate = 'partner_delete';
                $crudRoutePart = 'partners';

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
                return $row->total_people ? $row->total_people : "";
            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'school', 'photo']);

            return $table->make(true);
        }

        return view('admin.partners.index');
    }

    public function create()
    {
        abort_if(Gate::denies('partner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $partner_categories = PartnerCategory::all()->pluck('name', 'id');
        $partner_activities = PartnerActivity::all()->pluck('name', 'id');

        return view('admin.partners.create', compact('schools', 'partner_categories', 'partner_activities'));
    }

    public function store(StorePartnerRequest $request)
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
        $partner = Partner::query()->create($request->all());

        if ($request->get('photo', false)) {
            $partner->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
        }

        if ($partner) {
            session()->flash('message', __('global.is_created'));
        }

        if ($request->get('add_more')) {
            return redirect()->route('admin.partners.create');
        } else {
            return redirect()->route('admin.partners.index');
        }
    }

    public function edit(Request $request, Partner $partner)
    {
        abort_if(Gate::denies('partner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $schoolsQuery = School::query();
        $schools = $schoolsQuery->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $partner_categories = PartnerCategory::all()->pluck('name', 'id');
        $partner_activities = PartnerActivity::all()->pluck('name', 'id');

        return view('admin.partners.edit', compact('schools', 'partner_categories', 'partner_activities', 'partner'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
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

        return redirect()->route('admin.partners.index');

    }

    public function show(Partner $partner)
    {
        abort_if(Gate::denies('partner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.partners.show', compact( 'partner'));
    }

    /**
     * @param Partner $partner
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Partner $partner)
    {
        abort_if(Gate::denies('partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $delete = $partner->delete();

        if ($delete) {
            session()->flash('message', __('global.is_deleted'));
        }

        return back();

    }

    public function massDestroy(MassDestroyPartnerRequest $request)
    {
        $query = Partner::query()->whereIn('id', $request->get('ids'));
        $items = $query->get();

        foreach ($items as $item) {
            $item->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
