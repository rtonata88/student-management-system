<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Center;
use App\StudentGuardian;
class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::paginate(50);
        $centers = Center::pluck('center_name', 'id');
        
        return view('Management.Students.Index', compact('students', 'centers'));
    }

    public function create()
    {
        $centers = Center::pluck('name', 'id');

        return view('Management.Students.Create', compact('centers'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $centers = Center::pluck('name', 'id');

        return view('Management.Students.Edit', compact('centers', 'student'));
    }

    public function show($id)
    {
        $student = Student::find($id);

        return view('Management.Students.Show', compact('student'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['student_number'] = $this->generateStudentNumber();
        $student = Student::create($data);

        $this->createStudentGuardian($student, $request);

        return redirect()->route('students.show', $student->id);
    }

    public function update(Request $request, $id)
    {

        $student = Student::find($id);
        $student->update($request->all());

        return redirect()->route('students.show', $id);
    }

    private function createStudentGuardian($student, $request)
    {
        for ($i = 0; $i < count($request->qualification_name); $i++) {
            StudentGuardian::create([
                'student_id' => $student->id,
                'guardian_names' => $request->guardian_names[$i],
                'surname' => $request->surname[$i],
                'relationship' => $request->relationship[$i],
                'contact_number' => $request->contact_number[$i],
                'contact_email' => $request->contact_email[$i]
            ]);
        }
    }
}
