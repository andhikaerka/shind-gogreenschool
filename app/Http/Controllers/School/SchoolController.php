<?php

namespace App\Http\Controllers\School;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdateSchoolRequest;
use App\Province;
use App\School;
use App\SchoolProfile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpFoundation\Response;

class SchoolController extends Controller
{
    use MediaUploadingTrait;

    public function edit(Request $request, $school_slug)
    {
        abort_if(Gate::denies('school_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        School::query()->where('slug', $school_slug)->findOrFail(auth()->user()->isSTC);

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', $school->id)
            ->where('year', $request->get('year', date('Y')))
            ->first();

        $provinces = Province::all()->pluck('name', 'code');

        return view('school.schools.edit', compact('school_slug', 'provinces', 'school', 'schoolProfile'));
    }

    public function update(UpdateSchoolRequest $request, $school_slug)
    {
        School::query()->where('slug', $school_slug)->findOrFail(auth()->user()->isSTC);

        $school = School::query()->where('slug', $school_slug)->first();

        if (!$school) {
            return abort(404);
        }

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', $school->id)
            ->where('year', $request->get('year', date('Y')))
            ->first();

        $city = City::query()->where('code', $request->get('city'))->firstOrFail();
        $request->merge(['city_id' => $city['id']]);
        $school->update($request->all());
        if ($schoolProfile) {
            $schoolProfile->update($request->all());
        } else {
            $schoolProfile = new SchoolProfile([
                'school_id' => $school->id,
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
        if ($request->get('password')) {
            $school->user()->update(['password' => Hash::make($request->get('password'))]);
        }
        $school->user()->update([
            'name' => $school['name'],
            'email' => $school['email'],
        ]);

        if ($request->get('logo', false)) {
            if (!$school->logo || $request->get('logo') !== $school->logo->file_name) {
                $school->addMedia(storage_path('tmp/uploads/' . $request->get('logo')))->toMediaCollection('logo');
            }
        } elseif ($school->logo) {
            $school->logo->delete();
        }

        if ($request->get('photo', false) && $schoolProfile) {
            if (!$schoolProfile->photo || $request->get('photo') !== $schoolProfile->photo->file_name) {
                $schoolProfile->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            }
        } elseif ($school->photo) {
            $schoolProfile->photo->delete();
        }

        return redirect()->route('school.show', ['school_slug' => $school['slug'], 'year' => $request->get('year', date('Y'))]);
    }

    public function show(Request $request, $school_slug)
    {
        abort_if(Gate::denies('school_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', $school->id)
            ->where('year', $request->get('year', date('Y')))
            ->first();

        return view('school.schools.show', compact('school_slug', 'school', 'schoolProfile'));
    }

    public function print(Request $request, $school_slug)
    {
        abort_if(Gate::denies('school_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school = School::query()->where('slug', $school_slug)->firstOrFail();

        $schoolProfile = SchoolProfile::query()
            ->where('school_id', $school->id)
            ->where('year', $request->get('year', date('Y')))
            ->first();

        return view('school.schools.print', compact('school_slug', 'school', 'schoolProfile'));
    }

}
