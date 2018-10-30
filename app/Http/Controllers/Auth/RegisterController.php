<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'gender_id' => $data['gender_id'],
            'sector_id' => $data['sector_id'],
            'team_id' => $data['team_id'],
            'department_id' => $data['department_id'],
            'prefered_language' => $data['prefered_language'],
            'country_id' => $data['country_id'],
            'city_id' => $data['city_id'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        $sectors = \App\Sector::pluck('name', 'id');
        $gender = \App\Gender::pluck('gender', 'id');
        $teams = \App\Team::pluck('name', 'id');
        $departments = \App\Department::pluck('name', 'id');
        $countries = \App\Country::pluck('name', 'id');
        $cities = \App\City::pluck('name', 'id');
        $languages = \App\Language::pluck('name', 'id');

        return view('auth.register', compact('sectors', 'gender', 'teams', 'departments', 'countries', 'cities', 'languages'));
    }

    /* * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
     
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
     
        $this->create($request->all());
     
        return redirect(route('auth.success')); // Change this route to your needs
    }
}
