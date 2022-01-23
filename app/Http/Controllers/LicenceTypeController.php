<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LicenceType;

class LicenceTypeController extends Controller
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
        $license_types = LicenceType::all();

        return view('setup.license-types.index', compact('license_types'));
    }

    public function create()
    {
        return view('setup.license-types.create');
    }

    public function edit($id)
    {
        $license_type = LicenceType::find($id);

        return view('setup.license-types.edit', compact('license_type'));
    }

    public function store(Request $request)
    {
        LicenceType::create($request->all());

        return redirect()->route('license-types.index');
    }

    public function update(Request $request, $id)
    {
        LicenceType::where('id', $id)->update($request->except(['_method', '_token']));

        return redirect()->route('license-types.index');
    }
}
