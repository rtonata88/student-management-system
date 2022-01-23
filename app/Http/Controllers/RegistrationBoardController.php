<?php

namespace App\Http\Controllers;

use App\Country;
use App\RegistrationBoard;
use Illuminate\Http\Request;

class RegistrationBoardController extends Controller
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

    public function index(){
        $boards = RegistrationBoard::all();

        return view('setup.boards.index', compact('boards'));
    }

    public function create(){
        $countries = Country::pluck('name', 'id');
        return view('setup.boards.create', compact('countries'));
    }

    public function edit($id){
        $board = RegistrationBoard::find($id);
        $countries = Country::pluck('name', 'id');

        return view('setup.boards.edit', compact('board', 'countries'));
    }

    public function store(Request $request){
        RegistrationBoard::create($request->all());
        
        return redirect()->route('registration-boards.index');
    }

    public function update(Request $request, $id){
        RegistrationBoard::where('id', $id)->update($request->except(['_method', '_token']));

        return redirect()->route('registration-boards.index');
    }
}
