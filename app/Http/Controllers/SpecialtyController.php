<?php

namespace App\Http\Controllers;

use App\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $specialties = Specialty::all();

        return view('setup.specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('setup.specialties.create');
    }

    public function edit($id)
    {
        $specialty = Specialty::find($id);

        return view('setup.specialties.edit', compact('specialty'));
    }

    public function store(Request $request)
    {
        Specialty::create($request->all());

        return redirect()->route('specialties.index');
    }

    public function update(Request $request, $id)
    {
        Specialty::where('id', $id)->update($request->except(['_method', '_token']));

        return redirect()->route('specialties.index');
    }

}
