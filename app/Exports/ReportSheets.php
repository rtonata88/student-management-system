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

class ReportSheets implements FromCollection, WithTitle, WithHeadings
{
	private $key;
	protected $sector;

	public function __construct($sector, $key)
	{
		$this->sector = $sector;
		$this->key = $key;
	}


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$team_id = session()->get('team_id');
    	$start_date = session()->get('start_date');
    	$end_date = session()->get('end_date');

    	$sector = Sector::where('name', $this->sector)->first();

    	$team_report = ActivityTeamReport::report($sector->id, $team_id, $start_date, $end_date);
    	$media_coverage_report = ActivityTeamReport::media_coverage($sector->id, $team_id, $start_date, $end_date);
    	$events = ActivityTeamReport::events($sector->id, $team_id, $start_date, $end_date);

    	foreach ($media_coverage_report as $key => $coverage) {
    		$team_report->push($coverage);
    	}

    	foreach ($events as $key => $event) {
    		$team_report->push($event);
    	}
    	
    	$calls 		= $this->get_call_activities($team_report, $start_date, $end_date);
    	$emails 	= $this->get_email_activities($team_report, $start_date, $end_date);
    	$meetings 	= $this->get_meeting_activities($team_report, $start_date, $end_date);
    	$media 		= $this->get_media_activities($team_report, $start_date, $end_date);
    	$events 	= $this->get_event_activities($team_report, $start_date, $end_date);
    	
    	$activity_report = collect();
    	foreach ($team_report as $key => $value) {
    		$activity_report->push(collect($value)->only('Sector', 'Team', 'Activity', 'Occurence'));
    	}

    	
    	$report = [0=>$activity_report, 1=>$meetings, 2=>$calls, 3=>$emails, 4=>$events, 5=>$media];

    	return $report[$this->key]; 
    }


    public function title(): string
    {
    	$titles = [0=>'Daily Report Summary', 1=>'Meetings Summary', 2=>'Call Summary', 3=>'Email Summary', 4=>'Event Summary', 5=>'Articles'];
    	return $titles[$this->key];
    }

    public function headings(): array
    {
    	$headings = [
    		0=>array('Sector', 'Team', 'Activity', 'Occurence'),
    		1=>array('Fullname', 'Lastname', 'Position', 'Organisation', 'Country', 'Purpose of Meeting', 'Outcome'),
    		2=>array('Fullname', 'Lastname', 'Position', 'Organisation', 'Country','Incoming /Outgoing', 'Purpose of Call',	'Outcome'),
    		3=>array('Fullname', 'Lastname', 'Position', 'Organisation', 'Country','Incoming /Outgoing', 'Purpose of Email',	'Outcome'),
    		4=>array('Event Type',	'Name',	'Description',	'Purpose of Event', 'Date', 'Time', 'Outcome'),
    		5=>array('Coutry',	'Media House', 'Publishing Date', 'Title', 'Platform', 'Short Summary', 'URL', 'Location'),
    	];
    	return $headings[$this->key];

    }

    private function get_call_activities($team_report, $start_date, $end_date){
    	$activity = $team_report->where('Activity', 'Call');
    	$calls = collect();
    	foreach($activity as $activity){
    		$activities = ActivityTeamReport::get_activities($activity->sector_id, $activity->team_id, $activity->activity_type_id, $start_date, $end_date);
    		foreach ($activities as $key => $value) {
    			$calls->push(collect($value)->only('country', 'fullname', 'lastname', 'organization', 'position', 'direction', 'why', 'outcome'));
    		}
    	}
    	return $calls;
    }

    private function get_email_activities($team_report, $start_date, $end_date){

    	$activity = $team_report->where('Activity', 'Email');
    	$emails = collect();
    	foreach($activity as $activity){
    		$activities = ActivityTeamReport::get_activities($activity->sector_id, $activity->team_id, $activity->activity_type_id, $start_date, $end_date);
    		foreach ($activities as $key => $value) {
    			$emails->push(collect($value)->only('country', 'fullname', 'lastname', 'organization', 'position', 'direction', 'why', 'outcome'));
    		}
    	}
    	return $emails;
    }

    private function get_meeting_activities($team_report, $start_date, $end_date){
    	$activity = $team_report->where('Activity', 'Meeting');
    	$meetings = collect();
    	foreach($activity as $activity){
    		$activities = ActivityTeamReport::get_activities($activity->sector_id, $activity->team_id, $activity->activity_type_id, $start_date, $end_date);
    		

    		
    		foreach ($activities as $key => $value) {
    			$meetings->push(collect($value)->only('country', 'fullname', 'lastname', 'organization', 'position', 'why', 'outcome'));
    		}
    	}
    	return $meetings;
    }

    private function get_media_activities($team_report, $start_date, $end_date){
    	$activity = $team_report->where('Activity', 'Media coverage');
    	$media = collect();
    	foreach($activity as $activity){
    		$activities = ActivityTeamReport::get_media_coverage($activity->sector_id, $activity->team_id, $start_date, $end_date);

    		
    		foreach ($activities as $key => $value) {
    			$media->push(collect($value)->only('country', 'media_house', 'when', 'title', 'platform', 'short_summary', 'url', 'location'));
    		}
    	} 
    	return $media;        
    }


    private function get_event_activities($team_report, $start_date, $end_date){
    	$activity = $team_report->whereIn('Activity', ['Events Hosted', 'Events Attended']);
    	$events = collect();
    	foreach($activity as $activity){
    		$activities = ActivityTeamReport::get_events($activity->sector_id, $activity->team_id, $start_date, $end_date);

    		
    		foreach ($activities as $key => $value) {
    			$events->push(collect($value)->only('event_type', 'name', 'description', 'objectives', 'start_date', 'start_time'));
    		}
    	}
    	return $events;         
    }
}
