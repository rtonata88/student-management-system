<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassDuration;
use Illuminate\Support\Facades\Auth;

class ClassDurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-class-duration')->only(['index']);
        $this->middleware('permission:edit-class-duration')->only(['update']);
    }

    public function index()
    {
        $currentDuration = ClassDuration::getDefaultDuration();
        return view('class-durations.index', compact('currentDuration'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'duration_minutes' => 'required|integer|min:5|max:480'
        ]);

        ClassDuration::setDuration($request->duration_minutes);

        return redirect()->route('class-durations.index')
            ->with('success', 'Class duration updated successfully to ' . $request->duration_minutes . ' minutes.');
    }
}
