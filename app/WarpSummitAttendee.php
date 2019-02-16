<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class WarpSummitAttendee extends Model
{

	protected $fillable = ['date_attended', 'profile_id', 'current_or_former', 'financing', 'user'];

    public function profile(){
    	return $this->belongsTo(Profile::class);
    }

    public static function getWarpSummitAttendeesPerYear(){
    	$report = DB::table('warp_summit_attendees')
    				->get()
    				->groupBy(function ($val) {
				        return date('Y', strtotime($val->date_attended));
				    });

		return $report;
	}
}
