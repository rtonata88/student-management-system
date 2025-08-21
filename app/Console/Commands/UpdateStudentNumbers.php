<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\AcademicYear;
use App\Student;

class UpdateStudentNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:update-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing student numbers to new format (YYYYxxxxx)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting student number update...');

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

        $this->info("Using year prefix: {$yearPrefix}");

        // Get all students with old format student numbers (5 digits or less)
        $students = Student::where('student_number', '<', 100000)
            ->orWhereNull('student_number')
            ->get();

        $this->info("Found {$students->count()} students to update");

        $updated = 0;
        foreach ($students as $student) {
            $oldNumber = $student->student_number;
            $newStudentNumber = $this->generateUniqueStudentNumber($yearPrefix);
            
            $student->update(['student_number' => $newStudentNumber]);
            
            $this->line("Updated student ID {$student->id}: {$oldNumber} -> {$newStudentNumber}");
            $updated++;
        }

        $this->info("Successfully updated {$updated} student numbers!");
        return 0;
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
            $exists = Student::where('student_number', $studentNumber)->exists();
                
        } while ($exists);

        return $studentNumber;
    }
}
