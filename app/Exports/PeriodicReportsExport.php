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
	protected $sector;

	public function __construct($sector)
	{
		$this->sector = $sector;
	}

    public function sheets(): array
    {
    	$sheets = [];
    	for($i=0; $i<7; $i++){
    		$sheets[] =  new ReportSheets($this->sector, $i);
    	}

    	return $sheets;
    }

    public function headings(): array
    {
    	return [
    		'Sector', 'Team', 'Activity', 'Occurence',
    	];
    }
}
