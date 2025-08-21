<?php

namespace App\Http\Controllers;

use App\Examination;
use Illuminate\Http\Request;
use Auth;
use Session;

class ExaminationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if user has permission to view examinations
        if (!Auth::user()->hasPermission('examinations')) {
            abort(403, 'Unauthorized access to examinations.');
        }
        
        $search = $request->get('search');
        
        $examinations = Examination::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
        })
        ->orderBy('name')
        ->paginate(10);

        return view('Examinations.Index', compact('examinations', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        // Check if user has permission to add examinations
        if (!Auth::user()->hasPermission('add-examinations')) {
            abort(403, 'Unauthorized access to create examinations.');
        }
        
        return view('Examinations.Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user has permission to add examinations
        if (!Auth::user()->hasPermission('add-examinations')) {
            abort(403, 'Unauthorized access to create examinations.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:examinations,code',
            'mark_cap' => 'required|numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        Examination::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'mark_cap' => $request->mark_cap,
            'active' => $request->has('active')
        ]);

        Session::flash('success', 'Examination type created successfully');
        return redirect()->route('examinations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check if user has permission to edit examinations
        if (!Auth::user()->hasPermission('edit-examinations')) {
            abort(403, 'Unauthorized access to edit examinations.');
        }
        
        $examination = Examination::findOrFail($id);
        return view('Examinations.Edit', compact('examination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check if user has permission to edit examinations
        if (!Auth::user()->hasPermission('edit-examinations')) {
            abort(403, 'Unauthorized access to update examinations.');
        }
        
        $examination = Examination::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:examinations,code,' . $id,
            'mark_cap' => 'required|numeric|min:0|max:100',
            'active' => 'boolean'
        ]);

        $examination->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'mark_cap' => $request->mark_cap,
            'active' => $request->has('active')
        ]);

        Session::flash('success', 'Examination type updated successfully');
        return redirect()->route('examinations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if user has permission to delete examinations
        if (!Auth::user()->hasPermission('delete-examinations')) {
            abort(403, 'Unauthorized access to delete examinations.');
        }
        
        $examination = Examination::findOrFail($id);
        $examination->delete();

        Session::flash('success', 'Examination type deleted successfully');
        return redirect()->route('examinations.index');
    }
}
