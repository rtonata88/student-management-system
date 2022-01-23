<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminClerk;
use App\Country;
use App\Qualification;
use Illuminate\Foundation\Auth\User;

class AdminClerksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admin_clerks = AdminClerk::paginate(50);

        return view('admin-clerks.index', compact('admin_clerks'));
    }

    public function create()
    {
        $countries = Country::pluck('name', 'id');

        return view('admin-clerks.create', compact('countries'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);


        $data = $request->all();
        
        $admin_clerk = AdminClerk::create($data);

     
        $this->createQualification($admin_clerk, $request);
        $this->createUser($request);

        return redirect()->route('admin-clerks.index');
    }

    private function createQualification($admin_clerk, $request)
    {
        for ($i = 0; $i < count($request->qualification_name); $i++) {

            Qualification::create([
                'model' => "AdminClerk",
                'model_id' => $admin_clerk->id,
                'qualification_name' => $request->qualification_name[$i],
                'institution' => $request->institution[$i],
                'start_year' => $request->start_year[$i],
                'end_year' => $request->end_year[$i]
            ]);
        }
    }

    private function createUser($request)
    {
        //dd($request->name . ' ' . $request->surname);
        return User::create([
            'name' => $request->name . ' ' . $request->surname,
            'username' => $request->email,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ]);
    }
}
