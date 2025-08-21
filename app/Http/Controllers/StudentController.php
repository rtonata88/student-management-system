<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Center;
use App\Http\Requests\NewStudent;
use App\StudentGuardian;
use App\AcademicYear;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $students = Student::with('center')
            ->leftJoin('student_admissions', 'students.id', '=', 'student_admissions.student_id')
            ->select('students.*', 'student_admissions.admission_status')
            ->paginate(50);
        
        return view('Management.Students.Index', compact('students'));
    }

    public function filter(Request $request)
    {
        $students = Student::with('center')->paginate(100);

        if (isset($request->student_number)) {
            $students = Student::with('center')
                ->where(function($query) use ($request) {
                    $query->where('student_number2', $request->student_number)
                          ->orWhere('student_number', $request->student_number);
                })
                ->paginate(1);

            if ($students) {
                return view('Management.Students.Index', compact('students'));
            }
        }

        if (isset($request->names)) {
            $students = Student::with('center')
                                ->where('surname', 'like', '%' . $request->names . '%')
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
        $preGeneratedStudentNumber = $this->generateAndReserveStudentNumber();

        return view('Management.Students.Create', compact('centers', 'preGeneratedStudentNumber'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $centers = Center::pluck('center_name', 'id');
        $returnUrl = request('return');

        return view('Management.Students.Edit', compact('student', 'centers', 'returnUrl'));
    }

    public function show($id)
    {
        $student = Student::with('center')->find($id);
        $returnUrl = request('return');

        return view('Management.Students.Show', compact('student', 'returnUrl'));
    }

    public function store(NewStudent $request)
    {
        $data = $request->all();
        
        // Use the reserved student number from the session or generate a new one
        if (session()->has('reserved_student_number')) {
            $studentNumber = session('reserved_student_number');
            // Clear the reservation from cache and session
            Cache::forget('student_number_' . $studentNumber);
            session()->forget('reserved_student_number');
        } else {
            $studentNumber = $this->generateUniqueStudentNumber();
        }
        
        $data['student_number'] = $studentNumber;
        
        // Auto-assign center based on allocated number (student_number2) prefix
        if (isset($data['student_number2'])) {
            $allocatedNumber = strtoupper($data['student_number2']);
            if (strpos($allocatedNumber, 'OSH') === 0) {
                $oshanaCenter = Center::where('center_name', 'Oshana Centre')->first();
                if ($oshanaCenter) {
                    $data['center_id'] = $oshanaCenter->id;
                }
            } elseif (strpos($allocatedNumber, 'OMA') === 0) {
                $omafoCenter = Center::where('center_name', 'Omafo Centre')->first();
                if ($omafoCenter) {
                    $data['center_id'] = $omafoCenter->id;
                }
            }
        }
        
        $student = Student::create($data);

        return redirect()->route('students.index')->with('message', 'Student created successfully');

        return redirect()->route('enrolment.showEnrollmentScreen', $student->id);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        $data = $request->all();
        
        // Only auto-assign center based on allocated number if center_id is not manually selected
        if (!isset($data['center_id']) && isset($data['student_number2'])) {
            $allocatedNumber = strtoupper($data['student_number2']);
            if (strpos($allocatedNumber, 'OSH') === 0) {
                $oshanaCenter = Center::where('center_name', 'Oshana Centre')->first();
                if ($oshanaCenter) {
                    $data['center_id'] = $oshanaCenter->id;
                }
            } elseif (strpos($allocatedNumber, 'OMA') === 0) {
                $omafoCenter = Center::where('center_name', 'Omafo Centre')->first();
                if ($omafoCenter) {
                    $data['center_id'] = $omafoCenter->id;
                }
            }
        }

        $request->validate([
            'student_number2' => ['required',
                Rule::unique('students')->ignore($student->id)]
        ]);

        
        $student->update($data);

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
        // Get the active academic year
        $activeAcademicYear = AcademicYear::where('status', 1)->first();
        
        // Extract the year from the academic year (e.g., "2024/2025" -> "2025")
        $yearPrefix = '2025'; // Default fallback
        if ($activeAcademicYear && $activeAcademicYear->academic_year) {
            // Handle formats like "2024/2025" or "2025"
            if (strpos($activeAcademicYear->academic_year, '/') !== false) {
                $years = explode('/', $activeAcademicYear->academic_year);
                $yearPrefix = trim($years[1]); // Use the second year (2025)
            } else {
                $yearPrefix = trim($activeAcademicYear->academic_year);
            }
        }
        
        // Generate random 5-digit number
        $randomNumber = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        
        // Combine year prefix with random number (e.g., 202523765)
        $student_number = $yearPrefix . $randomNumber;

        // Check if this student number already exists in students table OR is cached as reserved
        $existsInStudents = Student::where('student_number', $student_number)->exists();
        $isReserved = Cache::has('reserved_number_' . $student_number);
        
        if($existsInStudents || $isReserved){
            return $this->generateStudentNumber(); // Recursively generate a new number
        }

        return $student_number;
    }

    private function generateAndReserveStudentNumber()
    {
        $studentNumber = $this->generateStudentNumber();
        
        // Reserve the number in cache for 30 minutes
        Cache::put('reserved_number_' . $studentNumber, true, 30 * 60); // 30 minutes in seconds
        
        // Store in session for later use during form submission
        session(['reserved_student_number' => $studentNumber]);
        
        return $studentNumber;
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
