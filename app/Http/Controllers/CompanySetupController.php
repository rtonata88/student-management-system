<?php

namespace App\Http\Controllers;

use App\CompanySetup;
use Illuminate\Http\Request;


class CompanySetupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $company = CompanySetup::find($id);
        return view('Setup.Company.Show', compact('company'));
    }

    public function edit($id){
        $company = CompanySetup::find($id);

        return view('Setup.Company.Edit', compact('company'));
    }

    public function update(Request $request, $id){

        $logo = "";
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->storePublicly('company', 'local');
        }
        $data = $request->all();
        $data['logo'] = $logo;

        $company = CompanySetup::find($id)->update($data);

        return redirect()->route('company.show', 1);
    }

}
