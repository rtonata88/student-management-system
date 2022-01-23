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
        $students = Student::all();
        
        return view('Management.Students.Index', compact('students'));
    }

    public function filter(Request $request)
    {
        $students = Student::all();

        if(isset($request->student_number))
        {
            $students = $students->where('student_number', $request->student_number);
        }

        if (isset($request->surname)) {
            $students = $students->where('surname', $request->surname);
        }

        return view('Management.Students.Index', compact('students'));
    }

    public function create()
    {
        $centers = Center::pluck('center_name', 'id');

        return view('Management.Students.Create', compact('centers'));
    }

    public function edit($id)
    {
        $student = Student::find($id);

        return view('Management.Students.Edit', compact('student'));
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
            StudentGuardian::create([
                'student_id' => $student->id,
                'guardian_names' => $request->guardian_names,
                'surname' => $request->guardian_surname,
                'relationship' => $request->relationship,
                'contact_number' => $request->guardian_contact_number,
                'contact_email' => $request->guardian_contact_email
            ]);
        
    }

    private function generateStudentNumber()
    {
        $student_number = rand(10000, 99999);

        $student = Student::where('student_number', $student_number)->first();
        if(count($student) > 0){
            $this->generateStudentNumber();
        }

        return $student_number;
    }
}
