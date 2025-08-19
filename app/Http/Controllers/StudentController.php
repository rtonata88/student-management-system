<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Center;
use App\Http\Requests\NewStudent;
use App\StudentGuardian;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::leftJoin('student_admissions', 'students.id', '=', 'student_admissions.student_id')
            ->select('students.*', 'student_admissions.admission_status')
            ->paginate(50);
        
        return view('Management.Students.Index', compact('students'));
    }

    public function filter(Request $request)
    {
        $students = Student::paginate(100);

        if (isset($request->student_number)) {
            $students = Student::where('student_number2', $request->student_number)->paginate(1);

            if ($students) {
                return view('Management.Students.Index', compact('students'));
            }
        }

        if (isset($request->names)) {
            $students = Student::where('surname', 'like', '%' . $request->names . '%')
                                ->orwhere('student_names', 'like', '%' . $request->names. '%')
                                ->paginate(100);

            if (count($students)) {
                return view('Management.Students.Index', compact('students'));
            }
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
        $returnUrl = request('return');

        return view('Management.Students.Edit', compact('student', 'returnUrl'));
    }

    public function show($id)
    {
        $student = Student::find($id);
        $returnUrl = request('return');

        return view('Management.Students.Show', compact('student', 'returnUrl'));
    }

    public function store(NewStudent $request)
    {
        $data = $request->all();
        $data['student_number'] = $this->generateStudentNumber();
        $student = Student::create($data);

        $this->createStudentGuardian($student, $request);

        return redirect()->route('enrolment.showEnrollmentScreen', $student->id);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        $request->validate([
            'student_number2' => ['required',
                Rule::unique('students')->ignore($student->id)]
        ]);

        
        $student->update($request->all());

        $student->guardian()->delete();

        $this->createStudentGuardian($student, $request);

        $returnUrl = request('return');
        if ($returnUrl === 'manual-admissions') {
            return redirect()->route('manual-admissions.index');
        }
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
        if($student){
            $this->generateStudentNumber();
        }

        return $student_number;
    }

    public function getAdmissionStatus($id)
    {
        $admission = DB::table('student_admissions')
            ->where('student_id', $id)
            ->orderBy('status_date', 'desc')
            ->first();

        return response()->json([
            'success' => true,
            'admission' => $admission
        ]);
    }

    public function updateAdmissionStatus(Request $request, $id)
    {
        $request->validate([
            'admission_status' => 'required|in:rejected,provisionally_admitted,full_admission',
            'remarks' => 'nullable|string|max:1000'
        ]);

        try {
            // Use updateOrInsert to ensure only one record per student
            DB::table('student_admissions')->updateOrInsert(
                ['student_id' => $id], // Where condition
                [
                    'admission_status' => $request->admission_status,
                    'remarks' => $request->remarks,
                    'status_date' => now(),
                    'updated_at' => now(),
                    'created_at' => now() // Only used if inserting
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Admission status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update admission status'
            ], 500);
        }
    }
}
