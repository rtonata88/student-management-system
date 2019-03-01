<?php

namespace App\Exports;

use App\Documentation;
use EloquentBuilder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class DocumentationsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	 $documentations = Documentation::select('documentation_types.type', 'profiles.fullname', 'profiles.lastname', 'genders.gender', 'profiles.dob', 'profiles.position', 'organizations.name as organization', 'sectors.name as sector', 'countries.name as country', 'cities.name as city', 'profiles.mobile_no', 'profiles.work_number', 'profiles.email', 'documentations.effective_date')
            ->join('profiles', 'profiles.id', '=', 'documentations.id')
            ->leftJoin('genders', 'genders.id', '=', 'profiles.gender_id')
            ->leftjoin('organizations', 'organizations.id', '=', 'profiles.organization_id')
            ->leftJoin('sectors', 'sectors.id', '=', 'profiles.sector_id')
            ->leftJoin('countries', 'countries.id', '=', 'profiles.country_id')
            ->leftJoin('cities', 'cities.id', '=', 'profiles.city_id')
            ->leftjoin('documentation_types', 'documentation_types.id', '=', 'documentations.documentation_type_id');

    	$documentation_filter = session()->get('documentation_filter');

        $documentations = EloquentBuilder::to($documentations, $documentation_filter);
        return $documentations->get();
    }

    public function headings(): array
    {
    	return [
    		'Documnent', 'Fullname', 'Lastname', 'Gender', 'Dob', 'Position', 'Organization', 'Sector', 'Country', 'City', 'Mobile', 'Work_number', 'Email', 'Effective Date'
    	];
    }
}
