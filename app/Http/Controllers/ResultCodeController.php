<?php

namespace App\Http\Controllers;

use App\ResultCode;
use Illuminate\Http\Request;
use Auth;
use Session;

class ResultCodeController extends Controller
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
        // Check if user has permission to view result codes
        if (!Auth::user()->hasPermission('result-codes')) {
            abort(403, 'Unauthorized access to result codes.');
        }
        
        $search = $request->get('search');
        
        $resultCodes = ResultCode::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        })
        ->orderBy('name')
        ->paginate(10);

        return view('ResultCodes.Index', compact('resultCodes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        // Check if user has permission to add result codes
        if (!Auth::user()->hasPermission('add-result-codes')) {
            abort(403, 'Unauthorized access to create result codes.');
        }
        
        return view('ResultCodes.Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check if user has permission to add result codes
        if (!Auth::user()->hasPermission('add-result-codes')) {
            abort(403, 'Unauthorized access to create result codes.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:result_codes,code',
            'description' => 'nullable|string',
            'pass_fail' => 'required|in:Pass,Fail',
            'active' => 'boolean'
        ]);

        ResultCode::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'pass_fail' => $request->pass_fail,
            'active' => $request->has('active')
        ]);

        Session::flash('success', 'Result code created successfully');
        return redirect()->route('result-codes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ResultCode  $resultCode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResultCode  $resultCode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check if user has permission to edit result codes
        if (!Auth::user()->hasPermission('edit-result-codes')) {
            abort(403, 'Unauthorized access to edit result codes.');
        }
        
        $resultCode = ResultCode::findOrFail($id);
        return view('ResultCodes.Edit', compact('resultCode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResultCode  $resultCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Check if user has permission to edit result codes
        if (!Auth::user()->hasPermission('edit-result-codes')) {
            abort(403, 'Unauthorized access to update result codes.');
        }
        
        $resultCode = ResultCode::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:result_codes,code,' . $id,
            'description' => 'nullable|string',
            'pass_fail' => 'required|in:Pass,Fail',
            'active' => 'boolean'
        ]);

        $resultCode->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'pass_fail' => $request->pass_fail,
            'active' => $request->has('active')
        ]);

        Session::flash('success', 'Result code updated successfully');
        return redirect()->route('result-codes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResultCode  $resultCode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if user has permission to delete result codes
        if (!Auth::user()->hasPermission('delete-result-codes')) {
            abort(403, 'Unauthorized access to delete result codes.');
        }
        
        $resultCode = ResultCode::findOrFail($id);
        $resultCode->delete();

        Session::flash('success', 'Result code deleted successfully');
        return redirect()->route('result-codes.index');
    }
}
