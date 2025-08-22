<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Center;
use App\CompanySetup;
use PDF;
use Session;

class StudentLetterController extends Controller
{
    /**
     * Display the student search interface
     */
    public function index()
    {
        return view('StudentLetters.Search');
    }

    /**
     * Filter students based on search criteria
     */
    public function filter(Request $request)
    {
        $query = Student::with('center');
        
        // Search by student number (both student_number and student_number2)
        if ($request->filled('student_number')) {
            $studentNumber = $request->student_number;
            $query->where(function($q) use ($studentNumber) {
                $q->where('student_number', 'LIKE', "%{$studentNumber}%")
                  ->orWhere('student_number2', 'LIKE', "%{$studentNumber}%");
            });
        }
        
        // Search by student names
        if ($request->filled('names')) {
            $names = $request->names;
            $query->where(function($q) use ($names) {
                $q->where('student_names', 'LIKE', "%{$names}%")
                  ->orWhere('surname', 'LIKE', "%{$names}%");
            });
        }
        
        $students = $query->get();
        
        if ($students->isEmpty()) {
            Session::flash('message', 'No students found matching your search criteria.');
        }
        
        return view('StudentLetters.Search', compact('students'));
    }

    /**
     * Show letter generation form for specific student
     */
    public function generate($studentId)
    {
        $student = Student::with('center')->findOrFail($studentId);
        $company = CompanySetup::first();
        
        $letterTypes = [
            'testimonial' => 'Testimonial Letter',
            'completion' => 'Letter of Completion',
            'achievement' => 'Letter of Achievement',
            'enrollment' => 'Letter of Enrollment',
            'conduct' => 'Letter of Good Conduct',
            'recommendation' => 'Letter of Recommendation',
            'attendance' => 'Letter of Attendance',
            'verification' => 'Student Verification Letter'
        ];
        
        return view('StudentLetters.Generate', compact('student', 'company', 'letterTypes'));
    }

    /**
     * Preview the generated letter
     */
    public function preview(Request $request, $studentId)
    {
        $request->validate([
            'letter_type' => 'required|string',
            'custom_content' => 'nullable|string'
        ]);
        
        $student = Student::with('center')->findOrFail($studentId);
        $company = CompanySetup::first();
        $letterType = $request->letter_type;
        $customContent = $request->custom_content;
        
        // Generate letter content based on type
        $letterContent = $this->generateLetterContent($student, $letterType, $customContent);
        
        return view('StudentLetters.Preview', compact('student', 'company', 'letterType', 'letterContent'));
    }

    /**
     * Download letter as PDF
     */
    public function download(Request $request, $studentId)
    {
        $request->validate([
            'letter_type' => 'required|string',
            'custom_content' => 'nullable|string'
        ]);
        
        $student = Student::with('center')->findOrFail($studentId);
        $company = CompanySetup::first();
        $letterType = $request->letter_type;
        $customContent = $request->custom_content;
        
        // Generate letter content based on type
        $letterContent = $this->generateLetterContent($student, $letterType, $customContent);
        
        $pdf = PDF::loadView('StudentLetters.Print', compact('student', 'company', 'letterType', 'letterContent'));
        
        $filename = $this->generateFilename($student, $letterType);
        
        return $pdf->download($filename);
    }

    /**
     * Generate letter content based on type
     */
    private function generateLetterContent($student, $letterType, $customContent = null)
    {
        $studentName = $student->student_names . ' ' . $student->surname;
        $centerName = $student->center ? $student->center->center_name : 'our institution';
        $currentDate = date('F j, Y');
        
        if ($customContent) {
            return $customContent;
        }
        
        switch ($letterType) {
            case 'testimonial':
                return "This is to certify that {$studentName} (Student Number: {$student->student_number}) has been a student at {$centerName}. During their time with us, they have demonstrated excellent academic performance and exemplary conduct. We are pleased to provide this testimonial as a reference for their future endeavors.";
                
            case 'completion':
                return "This letter serves to confirm that {$studentName} (Student Number: {$student->student_number}) has successfully completed their studies at {$centerName}. They have fulfilled all the requirements of their program and have demonstrated satisfactory academic achievement throughout their course of study.";
                
            case 'achievement':
                return "We are pleased to acknowledge the outstanding academic achievement of {$studentName} (Student Number: {$student->student_number}) at {$centerName}. Their dedication to excellence and consistent high performance has earned them recognition among their peers. We commend their commitment to academic excellence.";
                
            case 'enrollment':
                return "This letter confirms that {$studentName} (Student Number: {$student->student_number}) is currently enrolled as a student at {$centerName}. They are in good standing and actively pursuing their studies with us. This letter is issued upon request for official purposes.";
                
            case 'conduct':
                return "This is to certify that {$studentName} (Student Number: {$student->student_number}) has maintained exemplary conduct during their enrollment at {$centerName}. They have consistently demonstrated good character, respect for institutional policies, and positive interaction with fellow students and staff.";
                
            case 'recommendation':
                return "It is with great pleasure that we recommend {$studentName} (Student Number: {$student->student_number}), who has been a student at {$centerName}. They have shown exceptional dedication to their studies, strong work ethic, and excellent interpersonal skills. We highly recommend them for future academic or professional opportunities.";
                
            case 'attendance':
                return "This letter confirms that {$studentName} (Student Number: {$student->student_number}) has maintained regular attendance at {$centerName}. Their attendance record demonstrates commitment to their educational goals and responsibility towards their academic obligations.";
                
            case 'verification':
                return "This letter serves as official verification that {$studentName} (Student Number: {$student->student_number}) is/was a registered student at {$centerName}. This verification is provided for official purposes and confirms their student status with our institution.";
                
            default:
                return "This letter is issued to {$studentName} (Student Number: {$student->student_number}) from {$centerName}. Please contact our office if you require any additional information or clarification regarding this student's status with our institution.";
        }
    }

    /**
     * Generate filename for PDF download
     */
    private function generateFilename($student, $letterType)
    {
        $studentName = str_replace(' ', '_', $student->student_names . '_' . $student->surname);
        $letterTypeName = str_replace(' ', '_', ucwords(str_replace('_', ' ', $letterType)));
        $date = date('Y-m-d');
        
        return "{$letterTypeName}_{$studentName}_{$date}.pdf";
    }
}
