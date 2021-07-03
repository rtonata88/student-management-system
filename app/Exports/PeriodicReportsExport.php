<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use App\Sector;
use App\ActivityTeamReport;
use App\Exports\ReportSheets;

class PeriodicReportsExport implements WithMultipleSheets, WithHeadings, WithStrictNullComparison
{

    public function sheets(): array
    {
    	$sheets = [];
    	for($i=0; $i<5; $i++){
    		$sheets[] =  new ReportSheets($i);
    	}

    	return $sheets;
    }

    public function headings(): array
    {
    	return [
    		'Team', 'Report type', 'Count',
    	];
    }
}
