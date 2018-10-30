<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventMiscellaneous;
use DB;
class EventReportConfiguration extends Model
{
    public function misc_report(){
        $miscs = EventMiscellaneous::whereIn('id', $this->get_event_report_misc_ids($this->id))->get();
        
        return $miscs;
    } 

    public function get_event_report_misc_ids($report_id){
        return DB::table('event_report_miscs')
                ->where('report_id', $report_id)
                ->pluck('misc_id');
    }

    public function is_included($misc_id, $report_id){
    	$misc_report = DB::table('event_report_miscs')
		                ->where('report_id', $report_id)
		                ->where('misc_id', $misc_id)
		                ->first();

		if($misc_report){
			return true;
		} else {
			return false;
		}
    }
}
