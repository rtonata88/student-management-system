<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class ActivityTeamReport extends Model
{
    public function sector(){
    	return $this->belongsTo('App\Sector');
    }

    public static function report($sector_id, $team_id, $start_date, $end_date){

    	return DB::table('activities')
    					->join('activity_profile', 'activity_profile.activity_id', '=', 'activities.id')
    					->join('profiles', function($join) use ($sector_id, $team_id){
    						$join->on('activity_profile.profile_id', '=', 'profiles.id')
    							->where('profiles.sector_id', '=', $sector_id);
    							if($team_id > 0){
    								$join->where('profiles.team_id', '=', $team_id);
    							}
    					})
    					->join('teams', 'teams.id', '=', 'profiles.team_id')
    					->join('sectors', function($join) use ($sector_id) {
    						$join->on('sectors.id', '=', 'teams.sector_id')	
    						->where('teams.sector_id', '=',$sector_id);
    					})
    					->join('activity_types', 'activity_types.id', '=', 'activities.activity_type_id')
    					->selectRaw('profiles.sector_id, sectors.name as Sector, profiles.team_id, teams.name AS Team,activity_types.name AS Activity,activity_types.id AS activity_type_id,count(activities.activity_type_id) AS Occurence ')
    					->where('sectors.id', $sector_id)
    					->whereRaw("DATE_FORMAT(`when`, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")
    					->groupBy(['teams.name','activity_types.name'])
    					->get();
    }

    public static function media_coverage($sector_id, $team_id, $start_date, $end_date){

		return DB::table('media_coverages')
					->join('profiles', function($join) use ($sector_id, $team_id){
						$join->on('media_coverages.profile_id', '=', 'profiles.id')
							->where('profiles.sector_id', '=', $sector_id);
							if($team_id > 0){
								$join->where('profiles.team_id', '=', $team_id);
							}
					})
					->join('teams', 'teams.id', '=', 'profiles.team_id')
    				->join('sectors', 'sectors.id', '=', 'teams.sector_id')
    				->selectRaw('sectors.id AS sector_id, sectors.name AS Sector,teams.id as team_id, teams.name as Team, "Media coverage" AS Activity,count(media_coverages.profile_id) AS Occurence')
    				->where('sectors.id', $sector_id)
    				->whereRaw("DATE_FORMAT(`when`, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")
    				->groupBy('teams.name')
    				->get();

    }

    public static function events($sector_id, $team_id, $start_date, $end_date){

		$events =  DB::table('events')
					->join('event_team', 'event_team.event_id', '=', 'events.id')
					->join('teams', 'teams.id', '=', 'event_team.team_id')
    				->join('sectors', 'sectors.id', '=', 'teams.sector_id')
    				->selectRaw('sectors.id AS sector_id,`sectors`.`name` AS `Sector`, teams.id team_id, teams.name as Team,
										case 
											when `events`.`event_type` = "internal" then "Events Hosted" 
											when `events`.`event_type` = "external" then "Events Attended" 
										end AS `Activity`,
										count(`events`.`name`) AS `Occurence`')
    				->where('sectors.id', $sector_id)
    				
    				->whereRaw("DATE_FORMAT(`start_date`, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")
    				->groupBy('teams.name', 'events.event_type');

    				if($team_id > 0){
    					$events = $events->where('teams.id', $team_id);
    				}
    				$events = $events->get();

    	return $events;

    }

    public static function get_activities($sector_id, $team_id, $activity_type_id, $start_date, $end_date){
    	$activities = DB::table('activities')
    					->join('activity_profile', 'activity_profile.activity_id', '=', 'activities.id')
    					->join('profiles', 'activity_profile.profile_id', '=', 'profiles.id')
    					->join('countries', 'countries.id', '=', 'profiles.country_id')
    					->join('sectors', 'sectors.id', '=', 'profiles.sector_id')
    					->join('teams', 'teams.id', '=', 'profiles.team_id')
    					->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
    					->select('profiles.fullname', 'profiles.lastname', 'profiles.position', 'organizations.name as organization', 'countries.name as country',
    							 'activities.direction','activities.when', 'activities.time', 'activities.why', 'activities.outcome', 
    							'activities.venue')
    					->where('sectors.id', $sector_id)
    					->where('teams.id', $team_id)
    					->where('activity_type_id', $activity_type_id)
    					->whereRaw("DATE_FORMAT(`when`, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")
    					->get();

    		
    	return $activities;
    }


    public static function get_media_coverage($sector_id, $team_id, $start_date, $end_date){
    	$coverage = DB::table('media_coverages')
    					->join('profiles', 'profiles.id', '=', 'media_coverages.profile_id')
						->join('teams', 'teams.id', '=', 'profiles.team_id')
						->join('countries', 'countries.id', '=', 'media_coverages.country_id')
						->join('cities', 'cities.id', '=', 'media_coverages.city_id')
						->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
	    				->join('sectors', 'sectors.id', '=', 'teams.sector_id')
	    				->select('profiles.fullname', 'profiles.lastname', 'profiles.position', 'organizations.name as organization', 'countries.name as country',
	    							 'media_coverages.*', 'cities.name as city')
	    				->where('sectors.id', $sector_id)
	    				->where('teams.id', $team_id)
	    				->whereRaw("DATE_FORMAT(`when`, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")
	    				->get();

    		
    	return $coverage;
    }

    public static function get_events($sector_id, $team_id, $start_date, $end_date){
    	return DB::table('events')
					->join('event_team', 'event_team.event_id', '=', 'events.id')
					->join('teams', 'teams.id', '=', 'event_team.team_id')
    				->join('sectors', 'sectors.id', '=', 'teams.sector_id')
    				->distinct()
    				->select('events.*')
    				->where('sectors.id', $sector_id)
    				->whereRaw("DATE_FORMAT(`start_date`, '%Y-%m-%d') BETWEEN '".$start_date."' AND '".$end_date."'")
    				->get();
    }


    public static function sectorsDashboardAnalysis(){
        return DB::table('activities')
            ->join('activity_profile', 'activity_profile.activity_id', '=', 'activities.id')
            ->join('profiles', 'profiles.id', '=', 'activity_profile.profile_id')
            ->join('sectors', 'sectors.id', '=', 'profiles.sector_id')  
            ->selectRaw('sectors.name, count(*) as count')          
            ->groupBy('profiles.sector_id')
            ->get();
    }
}
