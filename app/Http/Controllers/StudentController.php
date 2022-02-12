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
        $request->validate([
            'student_number2' => 'required|unique:students',
        ]);

        $data = $request->all();
        $data['student_number'] = $this->generateStudentNumber();
        $student = Student::create($data);

        $this->createStudentGuardian($student, $request);

        return redirect()->route('enrolment.showEnrollmentScreen', $student->id);
    }

    public function update(Request $request, $id)
    {

        $student = Student::find($id);
        $student->update($request->all());

        return redirect()->route('students.show', $id);
    }

    private function createStudentGuardian($student, $request)
    {
        for($i=0; $i<count($request->guardian_names); $i++){
            if(isset($request->guardian_names[$i])){
                StudentGuardian::create([
                    'student_id' => $student->id,
                    'guardian_names' => $request->guardian_names[$i],
                    'surname' => $request->guardian_surname[$i],
                    'relationship' => $request->relationship[$i],
                    'contact_number' => $request->guardian_contact_number[$i],
                    'contact_email' => $request->guardian_contact_email[$i]
                ]);
            }
        }
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
