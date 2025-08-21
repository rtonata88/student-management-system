<?php

use Illuminate\Database\Seeder;
use App\AssessmentType;

class AssessmentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assessmentTypes = [
            [
                'name' => 'Normal Exams',
                'code' => 'NE',
                'mark_cap' => 100.00,
                'active' => true,
            ],
            [
                'name' => 'Supplementary Exams',
                'code' => 'SE',
                'mark_cap' => 50.00,
                'active' => true,
            ],
            [
                'name' => 'OSCE Exams',
                'code' => 'OE',
                'mark_cap' => 100.00,
                'active' => true,
            ],
            [
                'name' => 'OSCE Supplementary',
                'code' => 'OS',
                'mark_cap' => 70.00,
                'active' => true,
            ],
        ];

        foreach ($assessmentTypes as $assessmentType) {
            AssessmentType::create($assessmentType);
        }
    }
}
