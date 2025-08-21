<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Student;
use App\Center;

class UpdateStudentCenters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:update-centers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update student centers based on allocated number (student_number2) prefix';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting to update student centers based on allocated number prefixes...');

        // Get centers
        $oshanaCenter = Center::where('center_name', 'Oshana Centre')->first();
        $omafoCenter = Center::where('center_name', 'Omafo Centre')->first();

        if (!$oshanaCenter || !$omafoCenter) {
            $this->error('Required centers not found. Please ensure "Oshana Centre" and "Omafo Centre" exist.');
            return;
        }

        $updatedCount = 0;

        // Get all students with allocated numbers
        $students = Student::whereNotNull('student_number2')->get();

        foreach ($students as $student) {
            $allocatedNumber = strtoupper($student->student_number2);
            $centerId = null;

            if (strpos($allocatedNumber, 'OSH') === 0) {
                $centerId = $oshanaCenter->id;
            } elseif (strpos($allocatedNumber, 'OMA') === 0) {
                $centerId = $omafoCenter->id;
            }

            if ($centerId && $student->center_id !== $centerId) {
                $student->center_id = $centerId;
                $student->save();
                $updatedCount++;
                
                $centerName = $centerId === $oshanaCenter->id ? 'Oshana Centre' : 'Omafo Centre';
                $this->info("Updated student {$student->student_names} {$student->surname} ({$allocatedNumber}) -> {$centerName}");
            }
        }

        $this->info("Completed! Updated {$updatedCount} students with center assignments.");
    }
}
