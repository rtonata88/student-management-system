<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\CompanySetup;
use Session;

class StudentCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:student-cards');
    }

    /**
     * Display the student card search form
     */
    public function index()
    {
        return view('StudentCards.Search');
    }

    /**
     * Filter students based on search criteria
     */
    public function filter(Request $request)
    {
        $students = collect();
        
        if ($request->student_number) {
            $students = Student::where('student_number2', 'like', '%' . $request->student_number . '%')
                             ->orWhere('student_number', 'like', '%' . $request->student_number . '%')
                             ->get();
        } elseif ($request->names) {
            $students = Student::where('student_names', 'like', '%' . $request->names . '%')
                             ->orWhere('surname', 'like', '%' . $request->names . '%')
                             ->get();
        }

        if ($students->isEmpty()) {
            Session::flash('message', 'No students found matching your search criteria.');
            return redirect()->route('student-cards.index');
        }

        return view('StudentCards.Search', compact('students'));
    }

    /**
     * Generate and display student card
     */
    public function generate($id)
    {
        $student = Student::with(['center', 'currentRegistration', 'admission'])->findOrFail($id);
        $company = CompanySetup::first();
        
        return view('StudentCards.Generate', compact('student', 'company'));
    }

    /**
     * Print student card
     */
    public function print($id)
    {
        $student = Student::with(['center', 'currentRegistration', 'admission'])->findOrFail($id);
        $company = CompanySetup::first();
        
        return view('StudentCards.Print', compact('student', 'company'));
    }

    /**
     * Upload student photo
     */
    public function uploadPhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $student = Student::findOrFail($id);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo && file_exists(storage_path('app/public/' . $student->photo))) {
                unlink(storage_path('app/public/' . $student->photo));
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('student_photos', 'public');
            $student->photo = $photoPath;
            $student->save();

            Session::flash('success', 'Photo uploaded successfully!');
        }

        return redirect()->back();
    }
}
