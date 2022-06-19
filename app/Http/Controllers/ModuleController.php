<?php

namespace App\Http\Controllers;

use App\Fees;
use Illuminate\Http\Request;
use App\Module;
use App\ModuleExtraFee;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subjects = Module::all();

        return view('Setup.Subjects.Index', compact('subjects'));
    }

    public function create(){
        $fees = Fees::all();
        return view('Setup.Subjects.Create', compact('fees'));
    }

    public function edit($id)
    {
        $subject = Module::find($id);
        $fees = Fees::all();
        $module_extra_fees = $subject->extra_fees->pluck('fee_id')->toArray();

        return view('Setup.Subjects.Edit', compact('subject', 'fees', 'module_extra_fees'));
    }

    public function store(Request $request){
        $module = Module::create($request->all());

        if($request->fee_id){
            $this->AttachExtraFees($request->fee_id, $module);
        }

        return redirect()->route('subjects.index');
    }

    public function update(Request $request, $id){
        $subject = Module::find($id);
        $subject->update($request->all());
        if ($request->fee_id) {
            $this->AttachExtraFees($request->fee_id,$subject);
        }

        return redirect()->route('subjects.index');
    }

    private function AttachExtraFees($fees, $module){
        ModuleExtraFee::where('module_id', $module->id)->delete();

        foreach ($fees as $fee_id) {
            ModuleExtraFee::create(['module_id' => $module->id, 'fee_id' => $fee_id]);
        }
    }
}
