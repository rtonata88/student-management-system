<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fees;
class FeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $fees = Fees::all();

        return view('Setup.Fees.Index', compact('fees'));
    }

    public function create()
    {
        return view('Setup.Fees.Create');
    }

    public function edit($id)
    {
        $fee = Fees::find($id);
        return view('Setup.Fees.Edit', compact('fee'));
    }

    public function store(Request $request)
    {
        Fees::create($request->all());

        return redirect()->route('fees.index');
    }

    public function update(Request $request, $id)
    {
        $fee = Fees::find($id);
        $fee->update($request->all());

        return redirect()->route('fees.index');
    }
}
