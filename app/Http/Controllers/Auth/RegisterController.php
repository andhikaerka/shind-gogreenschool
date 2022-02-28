<?php

namespace App\Http\Controllers\Auth;

use App\City;
use App\EnvironmentalStatus;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\School;
use App\SchoolProfile;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:' . User::MAX_LENGTH_OF_NAME],
            'email' => ['required', 'string', 'email', 'max:' . Builder::$defaultStringLength, 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'level' => ['nullable', 'in:' . join(',', array_keys(School::LEVEL_SELECT))],
            'vision' => ['nullable', 'string', 'max:' . SchoolProfile::MAX_LENGTH_OF_VISION],
            'status' => ['nullable', 'in:' . join(',', array_keys(School::STATUS_SELECT))],
            'address' => ['required', 'string', 'max:' . School::MAX_LENGTH_OF_ADDRESS],
            'phone' => ['required', 'numeric', 'digits_between:10,20'],
            'total_students' => ['nullable', 'integer', 'min:1', 'max:2147483647'],
            'total_teachers' => ['nullable', 'integer', 'min:1', 'max:2147483647'],
            'total_land_area' => ['nullable', 'integer', 'min:1', 'max:2147483647'],
            'total_building_area' => ['nullable', 'integer', 'min:1', 'max:2147483647'],
            'city' => ['required', 'exists:cities,code'],
            'environmental_status' => ['required', 'exists:environmental_statuses,slug'],
            'checkbox' => ['required'],
        ], [], [
            'name' => strtolower(trans('crud.school.fields.name')),
            'level' => strtolower(trans('crud.school.fields.level')),
            'vision' => strtolower(trans('crud.school.fields.vision')),
            'status' => strtolower(trans('crud.school.fields.status')),
            'address' => strtolower(trans('crud.school.fields.address')),
            'phone' => strtolower(trans('crud.school.fields.phone')),
            'email' => strtolower(trans('crud.school.fields.email')),
            'total_students' => strtolower(trans('crud.school.fields.total_students')),
            'total_teachers' => strtolower(trans('crud.school.fields.total_teachers')),
            'total_land_area' => strtolower(trans('crud.school.fields.total_land_area')),
            'total_building_area' => strtolower(trans('crud.school.fields.total_building_area')),
            'city' => strtolower(trans('crud.school.fields.city')),
            'environmental_status' => strtolower(trans('crud.school.fields.environmental_status')),
            'checkbox' => '',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $environmental_status = EnvironmentalStatus::query()->where('slug', $data['environmental_status'])->firstOrFail();
        $city = City::query()->where('code', $data['city'])->firstOrFail();

        $school = School::query()->create([
            'name' => $data['name'],
            'level' => isset($data['level']) ? $data['level'] : null,
            'phone' => $data['phone'],
            'email' => $data['email'],
            'status' => isset($data['status']) ? $data['status'] : null,
            'city_id' => $city['id'],
            'address' => $data['address'],
            'user_id' => $user['id'],
        ]);

        $schoolProfile = SchoolProfile::query()->create([
            'school_id' => $school['id'],
            'year' => date('Y'),
            'vision' => isset($data['vision']) ? $data['vision'] : '',
            'environmental_status_id' => $environmental_status['id'],
            'total_teachers' => isset($data['total_teachers']) ? $data['total_teachers'] : 0,
            'total_students' => isset($data['total_students']) ? $data['total_students'] : 0,
            'total_land_area' => isset($data['total_land_area']) ? $data['total_land_area'] : 0,
            'total_building_area' => isset($data['total_building_area']) ? $data['total_building_area'] : 0,
        ]);

        if ($user && $school && $schoolProfile) {
            DB::commit();

            // session(['message' => 'Terima kasih telah bergabung di sistem online GoGreenSchool Indonesia <br>Tunggu pemberitahuan di email Anda untuk pengaktifan akun Anda.']);
            session()->flash('success_message', 'Terima kasih telah bergabung di sistem online GoGreenSchool Indonesia <br>Tunggu pemberitahuan di email Anda untuk pengaktifan akun Anda.');

            return $user;
        } else {
            DB::rollBack();

            return false;
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        // return $request->wantsJson() ? new Response('', 201) : redirect($this->redirectPath());
        return $request->wantsJson() ? new Response('', 201) : redirect()->route('register');
    }
}
