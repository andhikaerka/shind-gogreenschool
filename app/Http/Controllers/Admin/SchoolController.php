<?php

namespace App\Http\Controllers\Admin;

use App\BudgetPlan;
use App\City;
use App\Curriculum;
use App\Disaster;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySchoolRequest;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\LessonPlan;
use App\Partner;
use App\Province;
use App\School;
use App\SchoolProfile;
use App\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SchoolController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('school_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = School::with(['schoolSchoolProfiles.environmental_status', 'city', 'city.province', 'user'])->select(sprintf('%s.*', (new School)->table));
            $table = Datatables::of($query);

            $table->addIndexColumn();
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'school_show';
                $editGate = 'school_edit';
                $deleteGate = 'school_delete';
                $crudRoutePart = 'schools';

                $actions = '';
                /*if (Gate::check($viewGate)) {
                    $actions .= '<a class="btn btn-xs btn-primary" href="' . route('admin.' . $crudRoutePart . '.show', $row->id) . '">' . trans('global.view') . '</a>';
                }*/
                if (Gate::check($editGate)) {
                    $actions .= '<a class="btn btn-xs btn-info" href="' . route('admin.' . $crudRoutePart . '.edit', $row->id) . '">' . trans('global.edit') . '</a>&nbsp;';
                }
                if (Gate::check($deleteGate)) {
                    $actions .= '<form action="' . route('admin.' . $crudRoutePart . '.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'' . trans('global.areYouSure') . '\');" style="display: inline-block;">' .
                        '<input type="hidden" name="_method" value="DELETE">' .
                        '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                        '<input type="submit" class="btn btn-xs btn-danger" value="' . trans('global.delete') . '">' .
                        '</form>';
                }

                return $actions;
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? '<a href="'.route("school.dashboard", ['school_slug' => $row->slug]).'" target="_blank">'.$row->name.'</a>' : "";
            });
            $table->editColumn('environmental_status_name', function ($row) {
                return $row->schoolSchoolProfiles ? $row->schoolSchoolProfiles->last()->environmental_status->name : '';
            });
            $table->editColumn('level', function ($row) {
                return $row->level && isset(School::LEVEL_SELECT[$row->level]) ? School::LEVEL_SELECT[$row->level] : '';
            });
            $table->editColumn('vision', function ($row) {
                return $row->schoolSchoolProfiles ? $row->schoolSchoolProfiles->last()->vision ?? '' : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? School::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('total_students', function ($row) {
                return $row->schoolSchoolProfiles ? $row->schoolSchoolProfiles->last()->total_students ?? '' : '';
            });
            $table->editColumn('total_teachers', function ($row) {
                return $row->schoolSchoolProfiles ? $row->schoolSchoolProfiles->last()->total_teachers ?? '' : '';
            });
            $table->editColumn('total_land_area', function ($row) {
                return $row->schoolSchoolProfiles ? $row->schoolSchoolProfiles->last()->total_land_area ?? '' : '';
            });
            $table->editColumn('total_building_area', function ($row) {
                return $row->schoolSchoolProfiles ? $row->schoolSchoolProfiles->last()->total_building_area ?? '' : '';
            });
            $table->editColumn('logo', function ($row) {
                if ($photo = $row->logo) {
                    return '<a href="' . $photo->url . '" target="_blank"><img src="' . $photo->url . '" width="50px" height="50px" alt=""></a>';
                }

                return '';

            });
            $table->editColumn('photo', function ($row) {
                return $row->photo ? '<a href="' . $row->photo->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('environmental_status_name', function ($row) {
                return $row->environmental_status ? $row->environmental_status->name : '';
            });
            $table->addColumn('city_name', function ($row) {
                return $row->city ? $row->city->name : '';
            });
            $table->addColumn('city_province_name', function ($row) {
                return $row->city->province ? $row->city->province->name : '';
            });

            $table->addColumn('user_approved', function ($row) {
                if ($row->user && $row->user->approved) {
                    return '<input type="checkbox" disabled ' . (($row->user ? $row->user->approved : '') ? 'checked' : null) . '>';
                } elseif ($row->user && !$row->user->approved) {
                    /*return '<form action="' . route('admin.users.approved', $row->user->id) . '" method="POST" onsubmit="return confirm(\'' . trans('global.areYouSure') . '\');" style="display: inline-block;">' .
                        '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                        '<input type="submit" class="btn btn-xs btn-danger" value="' . trans('crud.user.fields.approved') . '">' .
                        '</form>';*/
                    return '';
                } else {
                    return '';
                }
            });

            $table->editColumn('approval_condition', function ($row) {
                return $row->approval_condition && isset(School::APPROVAL_CONDITION_SELECT[$row->approval_condition]) ? School::APPROVAL_CONDITION_SELECT[$row->approval_condition] : '';
            });
            $table->editColumn('approval_time', function ($row) {
                return $row->approval_time ? $row->approval_time . ' Bulan' : '';
            });

            $table->rawColumns(['actions', 'name', 'placeholder', 'logo', 'photo', 'city', 'user_approved', 'environmental_status_name']);

            return $table->make(true);
        }

        return view('admin.schools.index');
    }

    public function create()
    {
        abort_if(Gate::denies('school_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::query()
            ->selectRaw("cities.id, CONCAT(cities.name, ', ', provinces.name) as name")
            ->join('provinces', 'cities.province_id', '=', 'provinces.id')
            ->get()
            ->pluck('name', 'id')
            ->prepend(trans('global.pleaseSelect'), '');

        return view('admin.schools.create', compact('cities'));
    }

    public function store(StoreSchoolRequest $request)
    {

        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'approved' => true,
        ]);

        $request->merge(['user_id' => $user['id']]);
        $school = School::query()->create($request->all());

        if ($school) {
            session()->flash('message', __('global.is_created'));
        }

        /*if ($request->get('logo', false)) {
            $school->addMedia(storage_path('tmp/uploads/' . $request->get('logo')))->toMediaCollection('logo');
        }

        if ($request->get('photo', false)) {
            $school->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
        }*/

        return redirect()->route('admin.schools.index');

    }

    public function edit(Request $request, School $school)
    {
        abort_if(Gate::denies('school_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provinces = Province::all()->pluck('name', 'code');

        $school->load('city', 'user');

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', $school['id'])
            ->where('year', $request->get('year', date('Y')))
            ->first();

        return view('admin.schools.edit', compact('provinces', 'school', 'schoolProfile'));
    }

    public function update(UpdateSchoolRequest $request, School $school)
    {
        $city = City::query()->where('code', $request->get('city'))->firstOrFail();
        $request->merge(['city_id' => $city['id']]);

        $school->update($request->all());
        if ($request->get('approval_condition') && $request->get('approval_time')) {
            $school->user()->update(['approved' => true]);
        }
        if ($request->get('password')) {
            $school->user()->update(['password' => Hash::make($request->get('password'))]);
        }
        $school->user()->update([
            'name' => $school['name'],
            'email' => $school['email'],
        ]);

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', $school['id'])
            ->where('year', $request->get('year', date('Y')))
            ->first();
        if ($schoolProfile) {
            $schoolProfile->update($request->all());
        } else {
            $schoolProfile = new SchoolProfile([
                'school_id' => $school['id'],
                'year' => $request->get('year', date('Y')),
                'environmental_status_id' => 1,
                'vision' => $request->get('vision'),
                'total_teachers' => $request->get('total_teachers'),
                'total_students' => $request->get('total_students'),
                'total_land_area' => $request->get('total_land_area'),
                'total_building_area' => $request->get('total_building_area'),
            ]);
            $schoolProfile->save();
        }

        if ($request->get('logo', false)) {
            if (!$school->logo || $request->get('logo') !== $school->logo->file_name) {
                try {
                    $school->addMedia(storage_path('tmp/uploads/' . $request->get('logo')))->toMediaCollection('logo');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($school->logo) {
            $school->logo->delete();
        }

        if ($request->get('photo', false)) {
            if (!$schoolProfile->photo || $request->get('photo') !== $schoolProfile->photo->file_name) {
                try {
                    $schoolProfile->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
                } catch (DiskDoesNotExist $e) {
                } catch (FileDoesNotExist $e) {
                } catch (FileIsTooBig $e) {
                }
            }

        } elseif ($schoolProfile->photo) {
            $schoolProfile->photo->delete();
        }

        return redirect()->route('admin.schools.index');

    }

    public function show(School $school)
    {
        abort_if(Gate::denies('school_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school->load('city', 'user', 'schoolInfrastructures', 'schoolDisasters', 'schoolQualityReports', 'schoolTeams', 'schoolPartners', 'schoolWorkGroups', 'schoolBudgetPlans', 'schoolLessonPlans');

        return view('admin.schools.show', compact('school'));
    }

    /**
     * @param School $school
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(School $school)
    {
        abort_if(Gate::denies('school_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::transaction(function () use ($school) {
            $schoolProfiles = SchoolProfile::query()->where('school_id','=', $school['id'])->get();
            foreach ($schoolProfiles as $schoolProfile) {
                foreach ($schoolProfile->schoolProfilePartners as $partner) {
                    foreach ($partner->partnerStudies as $study) {
                        foreach ($study->studyWorkPrograms as $workProgram) {
                            foreach ($workProgram->workProgramCadreActivities as $cadreActivity) {
                                $cadreActivity->delete();
                            }

                            $workProgram->delete();
                        }

                        $study->delete();
                    }

                    $partner->delete();
                }

                BudgetPlan::query()->where('school_profile_id','=', $schoolProfile->id)->delete();

                foreach ($schoolProfile->schoolProfileCurricula as $curriculum) {
                    $curriculum->delete();
                }

                foreach ($schoolProfile->schoolProfileDisasters as $disaster) {
                    $disaster->delete();
                }

                foreach ($schoolProfile->schoolProfileLessonPlans as $lessonPlan) {
                    $lessonPlan->delete();
                }

                foreach ($schoolProfile->schoolProfileQualityReports as $qualityReport) {
                    $qualityReport->delete();
                }

                foreach ($schoolProfile->schoolProfileWorkGroups as $workGroup) {
                    foreach ($workGroup->workGroupActivities as $activity) {
                        $activity->delete();
                    }
                    foreach ($workGroup->workGroupInnovations as $innovation) {
                        $innovation->delete();
                    }
                    foreach ($workGroup->workGroupCadres as $cadre) {
                        $cadre->delete();
                    }
                    foreach ($workGroup->workGroupInfrastructures as $infrastructure) {
                        $infrastructure->delete();
                    }
                    foreach ($workGroup->workGroupTeams as $team) {
                        $team->delete();
                    }

                    $workGroup->delete();
                }

                $schoolProfile->delete();
            }

            $school->delete();
        });

        return back();

    }

    public function massDestroy(MassDestroySchoolRequest $request)
    {

        $schoolQuery = School::query()->whereIn('id', $request->get('ids'));
        $schools = $schoolQuery->get();
        foreach ($schools as $school) {
            $school->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);

    }

}
