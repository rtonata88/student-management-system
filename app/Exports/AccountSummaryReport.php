<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Illuminate\Contracts\Queue\ShouldQueue;


class AccountSummaryReport implements FromView, WithEvents, ShouldAutoSize, WithCustomChunkSize, WithStyles, WithColumnWidths, ShouldQueue
{
    use Exportable;

    protected $centers;
    protected $financial_year;
    protected $account_summary; 
    protected $extra_charges; 
    protected $extra_charges_details; 
    protected $payments;
    protected $invoices;
    protected $totals;
    protected $modules;
    protected $fees;
    protected $module_registrations;
    protected $guardians;
    protected $company;

    public function __construct($centers, $financial_year, $account_summary, $extra_charges, $extra_charges_details, $payments, $invoices,$totals, $modules, $fees, $module_registrations, $guardians, $company){
        $this->centers = $centers;
        $this->financial_year = $financial_year;
        $this->account_summary = $account_summary;
        $this->extra_charges = $extra_charges;
        $this->extra_charges_details = $extra_charges_details;
        $this->payments = $payments;
        $this->invoices = $invoices;
        $this->totals = $totals;
        $this->modules = $modules;
        $this->fees = $fees;
        $this->module_registrations = $module_registrations;
        $this->guardians = $guardians;
        $this->company = $company;
    }

    public function view(): View
    {
        return view('Reports.AccountSummary.Export', [
            'account_summary'           => $this->account_summary,
            'modules'                   => $this->modules,
            'module_registrations'      => $this->module_registrations,
            'extra_charges'             => $this->extra_charges,
            'extra_charges_details'     => $this->extra_charges_details,
            'payments'                  => $this->payments,
            'centers'                   => $this->centers,
            'guardians'                 => $this->guardians,
            'invoices'                  => $this->invoices,
            'totals'                    => $this->totals,
            'modules'                   => $this->modules,
            'fees'                      => $this->fees,
            'module_registrations'      => $this->module_registrations,
            'guardians'                 => $this->guardians,
            'company'                   => $this->company
        ]);
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

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                // Apply general styling for the entire sheet
                $event->writer->getDelegate()->getDefaultStyle()->getFont()->setSize(10);
                $event->writer->getDelegate()->getDefaultStyle()->getFont()->setName('Arial');
                

            },
            AfterSheet::class => function (AfterSheet $event) {
                // Apply styling to the headings row
                $event->sheet->getStyle('A9:' . $event->sheet->getHighestColumn() . '10')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DCE6F0');

                $event->sheet->getStyle($event->sheet->calculateWorksheetDimension())->getNumberFormat()->setFormatCode('#,##0');

                // Add a border around the headings row
                $event->sheet->getStyle('A9:' . $event->sheet->getHighestColumn() . '10')
                ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
            },
        ];
    }
}
