<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use \Nicolaslopezj\Searchable\SearchableTrait;

class Profile extends Model
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'profiles.fullname' => 5,
            'profiles.lastname' => 3,
        ],
    ];

    public function language(){
    	return $this->belongsTo('App\Language');
    }

    public function maintainer(){
    	return $this->belongsTo('App\Maintainer');
    }

    public function fruit_role(){
    	return $this->belongsTo('App\FruitRole');	
    }

    public function fruit_stage(){
    	return $this->belongsTo('App\FruitStage');	
    }

    public function fruit_level(){
    	return $this->belongsTo('App\FruitLevel');	
    }

    public function sector_relationship(){
    	return $this->belongsTo('App\SectorRelationship');	
    }

    public function sector(){
    	return $this->belongsTo('App\Sector');	
    }

    public function country(){
    	return $this->belongsTo('App\Country');	
    }

    public function city(){
    	return $this->belongsTo('App\City');	
    }

    public function organization(){
    	return $this->belongsTo('App\Organization');	
    }

    public function gender(){
    	return $this->belongsTo('App\Gender');	
    }

    public function team(){
    	return $this->belongsTo('App\Team');	
    }

    public function photos(){
        return $this->hasMany('App\ActivityPhoto');    
    }

    public function activities(){
        return $this->belongsToMany('App\Activity')->orderBy('created_at', 'desc');
    }

    public function documents(){
        return $this->hasMany('App\ProfileDocument');
    }

    public function meetings_count(){
        return (DB::table('profiles')
            ->join('activity_profile', 'activity_profile.profile_id', '=', 'profiles.id')
            ->join('activities', 'activities.id', '=', 'activity_profile.activity_id')
            ->join('activity_types', 'activity_types.id', '=', 'activities.activity_type_id')
            ->select('activity_profile.profile_id')
            ->where('profiles.slug', '=', $this->slug)
            ->where('activity_types.name', '=', 'Meeting')
            ->count());
    }

    public function calls_count(){
        return (DB::table('profiles')
            ->join('activity_profile', 'activity_profile.profile_id', '=', 'profiles.id')
            ->join('activities', 'activities.id', '=', 'activity_profile.activity_id')
            ->join('activity_types', 'activity_types.id', '=', 'activities.activity_type_id')
            ->select('activity_profile.profile_id')
            ->where('profiles.slug', '=', $this->slug)
            ->where('activity_types.name', '=', 'Call')
            ->count());
    }

    public function emails_count(){
        return (DB::table('profiles')
            ->join('activity_profile', 'activity_profile.profile_id', '=', 'profiles.id')
            ->join('activities', 'activities.id', '=', 'activity_profile.activity_id')
            ->join('activity_types', 'activity_types.id', '=', 'activities.activity_type_id')
            ->select('activity_profile.profile_id')
            ->where('profiles.slug', '=', $this->slug)
            ->where('activity_types.name', '=', 'Email')
            ->count());
    }

    public function messages_count(){
        return (DB::table('profiles')
            ->join('activity_profile', 'activity_profile.profile_id', '=', 'profiles.id')
            ->join('activities', 'activities.id', '=', 'activity_profile.activity_id')
            ->join('activity_types', 'activity_types.id', '=', 'activities.activity_type_id')
            ->select('activity_profile.profile_id')
            ->where('profiles.slug', '=', $this->slug)
            ->whereIn('activity_types.name', ['WhatsApp', 'Text Message (SMS)', 'Telegram'])
            ->count());
    }

    public function activitity_user(){
        return (DB::table('activities')
            ->join('activity_user', 'activity_user.activity_id', '=', 'activities.id')
            ->join('users', 'users.id', '=', 'activity_user.user_id')
            ->select('users.name')
            ->get());
    }

    public function coverage_count(){
     return (DB::table('profiles')
        ->join('media_coverages', 'media_coverages.profile_id', '=', 'profiles.id')
        ->select('media_coverages.id')
        ->where('profiles.id', '=', $this->id)
        ->count()); 
 }


    /**
     * Returns the action column html for datatables.
     *
     * @param \App\User
     * @return string
     */
    public static function laratablesCustomAction($profile)
    {
        return view('datatables.includes.profiles-action')->render();
    }


    /**
     * Returns the name column value for datatables.
     *
     * @param \App\User
     * @return string
     */
    public static function laratablesCustomName($profile)
    {
        return $profile->fullname . ' ' . $profile->lastname;
    }

     /**
     * first_name column should be used for sorting when name column is selected in Datatables.
     *
     * @return string
     */
    public static function laratablesOrderName()
    {
        return 'fullname';
    }

    /**
     * Adds the condition for searching the name of the user in the query.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @param string search term
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public static function laratablesSearchName($query, $searchValue)
    {
        return $query->orWhere('fullname', 'like', '%'. $searchValue. '%')
            ->orWhere('lastname', 'like', '%'. $searchValue. '%')
        ;
    }

    /**
     * Returns the data attribute for row id of the user.
     *
     * @return array
     */
    public function laratablesRowData()
    {
        return [
            'id' => $this->id,
        ];
    }

    public static function get_guest($guest_id){
        return DB::table('profiles')
                ->select('profiles.id as profile_id','profiles.fullname', 'profiles.lastname', 'profiles.email', 'profiles.mobile_no', 'profiles.work_number', 'organizations.name')
                ->join('organizations', 'profiles.organization_id', '=', 'organizations.id')
                ->where('profiles.id', $guest_id)
                ->get();
    }

    public function check_ins(){
        return $this->hasMany('App\EventCheckIn');
    }

}
