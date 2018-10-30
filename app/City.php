<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class City extends Model
{
	use Sluggable;
    
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function country()
    {
    	return $this->belongsTo('App\Country', 'country_id');
    }

    public function language(){
        return $this->belongsTo('App\Language');
    }
}
