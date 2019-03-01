<?php

namespace App\Exports;

use App\Profile;
use EloquentBuilder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class ProfilesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$profiles = Profile::select('profiles.fullname', 'profiles.lastname', 'genders.gender', 'profiles.dob', 'profiles.position', 'organizations.name as organization', 'sectors.name as sector', 'teams.name as team', 'countries.name as country', 'cities.name as city', 'profiles.mobile_no', 'profiles.work_number', 'profiles.email', 'profiles.assistant_number', 'profiles.assistant_email', 'fruit_levels.level as level', 'fruit_stages.stage as stage', 'maintainers.name as maintainer', 'fruit_roles.role as role', 'religions.name as religion')
    		->leftJoin('genders', 'genders.id', '=', 'profiles.gender_id')
    		->leftjoin('organizations', 'organizations.id', '=', 'profiles.organization_id')
    		->leftJoin('sectors', 'sectors.id', '=', 'profiles.sector_id')
    		->leftJoin('teams', 'teams.id', '=', 'profiles.team_id')
    		->leftJoin('countries', 'countries.id', '=', 'profiles.country_id')
    		->leftJoin('cities', 'cities.id', '=', 'profiles.city_id')
    		->leftJoin('fruit_levels', 'fruit_levels.id', '=', 'profiles.fruit_level_id')
    		->leftJoin('fruit_stages', 'fruit_stages.id', '=', 'profiles.fruit_stage_id')
    		->leftJoin('maintainers', 'maintainers.id', '=', 'profiles.maintainer_id')
    		->leftJoin('fruit_roles', 'fruit_roles.id', '=', 'profiles.fruit_role_id')
    		->leftJoin('religions', 'religions.id', '=', 'profiles.religion_id');


    	$user_filter = session()->get('user_filter');

        $profiles = EloquentBuilder::to($profiles, $user_filter);

        return $profiles->get();
    }

    public function headings(): array
    {
    	return [
    		'Fullname', 'Lastname', 'Gender', 'DOB', 'Position', 'Organization', 'Sector', 'Team', 'Country', 'City', 'Mobile', 'Work Number', 'Email', 'Assistant Number', 'Assistant Email', 'Fruit Level', 'Fruit Stage', 'Maintainer', 'Fruit Role', 'Religion',
    	];
    }
}
