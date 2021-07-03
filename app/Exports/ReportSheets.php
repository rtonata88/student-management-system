<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use App\TeamReport;
use App\ActivityTeamReport;
use App\Exports\ReportSheets;
use Auth;

class ReportSheets implements FromCollection, WithTitle, WithHeadings
{
	private $key;

	public function __construct($key)
	{
		$this->key = $key;
	}


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {			
		$user = Auth::user();
		$team = $this->teamFilter($user);
    	$date_from = $this->dateFromFilter($user);
    	$date_to = $this->dateToFilter($user);

		$team_report_summary = TeamReport::selectRaw('team_name, activity_type_name, count(activity_type_name) as count')
                                ->whereIn('team_id', $team)
                                ->whereBetween('when', [$date_from, $date_to])
                                ->groupBy('team_name', 'activity_type_name', 'activity_id')
                                ->orderBy('team_name')
                                ->get();
		
		$summary_report = collect();
        foreach($team_report_summary as $report){
            $summary_report->push(['team'=>$report->team_name, 
                                    'report_type' => $report->activity_type_name, 
                                    'count'=>$team_report_summary->where('activity_type_name', $report->activity_type_name)
                                                                 ->where('team_name', $report->team_name)
                                                                 ->count()]);
        }

        $summary_report = $summary_report->unique();

        $team_report_detail = TeamReport::whereBetween('when', [$date_from, $date_to])
                                ->whereIn('team_id', $team)
								->groupBy('activity_id', 'team_id')
                                ->orderBy('when', 'desc')
                                ->orderBy('time', 'asc')
                                ->get();

    	$media_coverage_report = ActivityTeamReport::media_coverage($sector->id, $team_id, $start_date, $end_date);
    	$events = ActivityTeamReport::events($sector->id, $team_id, $start_date, $end_date);

    	foreach ($media_coverage_report as $key => $coverage) {
    		$team_report->push($coverage);
    	}

    	foreach ($events as $key => $event) {
    		$team_report->push($event);
    	}
    	
    	$calls 		= $team_report_detail->where('activity_type_name', 'Call');
    	$emails 	= $team_report_detail->where('activity_type_name', 'Email');
    	//$meetings 	= $team_report_detail->where('activity_type_name', 'Meeting');
		$messages   = $team_report_detail->where('activity_type_name', 'TextMessage');
    	//$media 		= $this->get_media_activities($team_report, $start_date, $end_date);
    	//$events 	= $this->get_event_activities($team_report, $start_date, $end_date);
        
		$meetings = $team_report_detail->map(function ($team_report_detail) {
				return $team_report_detail->only(['fullname', 'lastname', 'team_name', 'meeting_type', 'venue', 'when','why', 'outcome']);
			});

		$calls = $team_report_detail->map(function ($team_report_detail) {
				return $team_report_detail->only(['fullname', 'lastname', 'team_name', 'direction', 'when','why', 'outcome']);
			});
		
		$messages = $team_report_detail->map(function ($team_report_detail) {
				return $team_report_detail->only(['fullname', 'lastname', 'team_name', 'direction', 'when','why', 'outcome']);
			});
		
		$emails = $team_report_detail->map(function ($team_report_detail) {
				return $team_report_detail->only(['fullname', 'lastname', 'team_name', 'direction', 'when','why', 'outcome']);
			});	

    	$activity_report = collect();
    	foreach ($summary_report as $key => $value) {
    		$activity_report->push(collect($value)->only('team', 'report_type', 'count'));
    	}
    	
		$report = [0=>$activity_report, 1=>$meetings, 2=>$calls, 3=>$emails, 4=>$messages /*, 5=>$events, 6=>$media*/];
		
    	return $report[$this->key]; 
    }


    public function title(): string
    {
	$titles = [0=>'Daily Report Summary', 1=>'Meetings Reports', 2=>'Call Reports', 3=>'Email Reports', 4 => 'Message Reports' /*, 4=>'Event Summary', 5=>'Articles'*/];
	$titles[$this->key];
    	return $titles[$this->key];
    }

    public function headings(): array
    {
    	$headings = [
    		0=>array('Team', 'Report type', 'Count'),
    		1=>array('Fullname', 'Lastname', 'Team', 'Meeting Type', 'Venue', 'When', 'Why', 'Outcome'),
    		2=>array('Fullname', 'Lastname', 'Team','Direction', 'When','Why',	'Outcome'),
    		3=>array('Fullname', 'Lastname', 'Team','Direction', 'When','Why',	'Outcome'),
			4=>array('Fullname', 'Lastname', 'Team','Direction', 'When','Why',	'Outcome'),
    		//=>array('Event Type',	'Name',	'Description',	'Purpose of Event', 'Date', 'Time', 'Outcome'),
    		// 5=>array('Coutry',	'Media House', 'Publishing Date', 'Title', 'Platform', 'Short Summary', 'URL', 'Location'),
            // 6=>array('Fullname', 'Lastname', 'Position', 'Organisation', 'Country','Incoming /Outgoing', 'Purpose of Email',    'Outcome'),
    	];
    	return $headings[$this->key];

    }

	private function teamFilter($user){
		if(session()->get('periodic_team_id') !== null){
			return [session()->get('periodic_team_id')];
		} else {
			return $user->team->pluck('id');
		}
	}

	private function dateFromFilter($user){
		if(session()->get('periodic_date_from') !== null){
			return session()->get('periodic_date_from');
		} else {
			return date('Y-m-01');
		}
	}

	private function dateToFilter($user){
		if(session()->get('periodic_team_id') !== null){
			return session()->get('periodic_date_to');
		} else {
			return date('Y-m-d');
		}
	}
}
