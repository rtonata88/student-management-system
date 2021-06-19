<?php

namespace App\Exports;

use App\WarpSummitAttendee;
use EloquentBuilder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class WarpSummitAttendeesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	 $warp = WarpSummitAttendee::select('warp_summit_attendees.date_attended', 'profiles.fullname', 'profiles.lastname', 'profiles.position', 'organizations.name as organization', 'countries.name as country', 'cities.name as city',  'warp_summit_attendees.current_or_former')
            ->join('profiles', 'profiles.id', '=', 'warp_summit_attendees.profile_id')
            ->leftjoin('organizations', 'organizations.id', '=', 'profiles.organization_id')
            ->leftJoin('countries', 'countries.id', '=', 'profiles.country_id')
            ->leftJoin('cities', 'cities.id', '=', 'profiles.city_id');

    	$warp_filter = session()->get('warp_filter');

        $warp = EloquentBuilder::to($warp, $warp_filter);
        return $warp->get();
    }

    public function headings(): array
    {
    	return [
    		'Date Attended', 'Fullname', 'Lastname', 'Position', 'Organization', 'Country', 'City', 'Current or Former'
    	];
    }
}
