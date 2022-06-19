<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class AccountSummaryReport implements FromCollection, ShouldAutoSize, WithCustomChunkSize, WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    public function collection()
    {
        ini_set('max_execution_time', '600');

        $account_summary = session()->get('account_summary');
        $modules         = session()->get('modules');
        $module_registrations = session()->get('module_registrations');
        $extra_charges   = session()->get('extra_charges');
        $payments        = session()->get('payments');
        $centers         = session()->get('centers');
        $guardians       = session()->get('guardians');
        $invoices       = session()->get('invoices');

        $export_data = collect();

        foreach ($account_summary as $summary) {
            $payment = $payments->where('student_id', $summary->student_id)->first()->payments ?? 0;
            $other_fees = floatval($extra_charges->where('student_id', $summary->student_id)->first()->outstanding) ?? 0;
            $payable_amount = ($other_fees + $summary->tuition_fees_payable) - $payment;
            $debit = $invoices->where('student_id', $summary->student_id)->first()->debit ?? 0;
            $credit = $invoices->where('student_id', $summary->student_id)->first()->credit ?? 0;
            $course_balance = $debit - $credit;

            $guardian_information = "";
            $index = 0;
            foreach ($guardians->where('student_id', $summary->student_id) as $guardian) {
                $guardian_information .= $guardian->guardian_names . " " . $guardian->surname . "(" . $guardian->relationship . ") - " . $guardian->contact_number;
                if($index < $guardians->where('student_id', $summary->student_id)->count()){
                    $guardian_information .= "\n";
                }
                $index++;
            }

            $student_data = array();
            $student_data['StudentNumber'] = $summary->student_number2;
            $student_data['StudentNames'] = $summary->student_names . " " . $summary->surname;
            $student_data['Center'] = $centers[$summary->center_id];
            $student_data['StudentContact'] = $summary->contact_number;
            $student_data['Guardian'] = $guardian_information;
            $student_data['TuitionFees'] = $summary->tuition_fees_payable - $payment;
            $student_data['OtherFees'] = $other_fees;
            $student_data['TotalPayable'] = $payable_amount;
            $student_data['CourseBalance'] = $course_balance;

            foreach($modules as $subject){
                
                if($module_registrations->where('module_id', $subject->id)->where('student_id', $summary->student_id)->first()){
                    $student_data[$subject->subject_name] = 'Enrolled';
                } else {
                    $student_data[$subject->subject_name] = "";
                }
            }
        
            $export_data->prepend(
                $student_data
            );
        }

        return  $export_data;
    }

    public function headings(): array
    {
        $modules = session()->get('modules')->pluck('subject_name')->toArray();

        $headings = [
            'Student number',
            'Student Names',
            'Center',
            'Student Contact',
            'Guardian Information',
            'Tuition Fees (N$)',
            'Other fees (N$)',
            'Total Payable (N$)',
            'Course Balance (N$)'
        ];

        return array_merge($headings, $modules);
    }

    public function chunkSize(): int
    {
        return 20;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'E'  => ['alignment' => ['wrapText' => true]]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 45,
            'E' => 80,
            'F' => 30,
            'G' => 30,
            'H' => 30,
        ];
    }
}
