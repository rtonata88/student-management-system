<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Event extends Model
{
    public function discussions()
    {
        return $this->hasMany('App\EventDiscussion');
    }

    public function participant_roles()
    {
        return $this->hasMany('App\EventParticipantRole');
    }

    public function participants()
    {
        return $this->hasMany('App\EventParticipant');
    }

    public function staff_roles()
    {
        return $this->hasMany('App\EventStaffRole');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function activities_log(){
        return $this->hasMany('App\EventActivityLog')->orderBy('created_at', 'desc');
    }


    public function other_particpants(){
        return $this->hasMany('App\EventOrganization');
    }


    public function count_attendees_status($status){
        $main_attendees = EventParticipant::where('rsvp_status', $status)->where('event_id', $this->id)->count();
        $other_attendees = EventOrganization::where('rsvp_status', $status)->where('event_id', $this->id)->count();
        $count = $main_attendees + $other_attendees;
        return $count;
    }

    public function event_staff(){
        return $this->hasMany('App\EventStaff');
    }

    public function co_hosts(){
        return $this->hasMany('App\EventCoHost');
    }

    public function media_coverage(){
        return $this->hasMany('App\MediaCoverage');
    }

    public function documents(){
        return $this->hasMany('App\EventDocument');
    }

    public function miscellaneous(){
        return $this->hasMany('App\EventMiscellaneous');
    }

    public function photos(){
        return $this->hasMany('App\EventGallery');
    }
    public function check_ins(){
        return $this->hasMany('App\EventCheckIn');
    }

    public function guest_register(){
        return DB::table('event_check_ins')
                    ->where('event_id', $this->id)
                    ->get();
    }

    public function guest_role($profile_id){
        return DB::table('event_participants')
            ->select('event_participant_roles.role_name')
            ->join('event_participant_roles', 'event_participant_roles.id', '=', 'event_participants.participant_role_id')
            ->where('event_participants.profile_id', $profile_id)
            ->first();
    }

    public function organization($profile_id){
         return DB::table('profiles')
            ->select('organizations.name')
            ->join('organizations', 'organizations.id', '=', 'profiles.organization_id')
            ->where('profiles.id', $profile_id)
            ->first();
    }


    public function report(){
        return $this->hasOne('App\EventReportConfiguration');
    }

    public function guest_feedback($guest_id){
        return DB::table('event_participants')
                        ->select('feedback')
                        ->where('profile_id', $guest_id)
                        ->first();
    }

    public function external_participants(){
        return $this->hasMany('App\ExternalEventParticipant');
    }

    public function team(){
        return $this->belongsToMany('App\Team');
    }

    public function sector(){
        return $this->belongsToMany('App\Sector');
    }
}
