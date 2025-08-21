<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\AcademicYear;

class UpdateExistingStudentNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

        // Get all students with old format student numbers (5 digits or less)
        $students = DB::table('students')
            ->where('student_number', '<', 100000) // Old format is 5 digits max
            ->orWhereNull('student_number')
            ->get();

        foreach ($students as $student) {
            $newStudentNumber = $this->generateUniqueStudentNumber($yearPrefix);
            
            DB::table('students')
                ->where('id', $student->id)
                ->update(['student_number' => $newStudentNumber]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration cannot be easily reversed as we're changing the format
        // You would need to restore from backup if needed
    }

    /**
     * Generate a unique student number in the new format
     */
    private function generateUniqueStudentNumber($yearPrefix)
    {
        do {
            // Generate random 5-digit number
            $randomNumber = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
            
            // Combine year prefix with random number (e.g., 202523765)
            $studentNumber = $yearPrefix . $randomNumber;
            
            // Check if this student number already exists
            $exists = DB::table('students')
                ->where('student_number', $studentNumber)
                ->exists();
                
        } while ($exists);

        return $studentNumber;
    }
}
