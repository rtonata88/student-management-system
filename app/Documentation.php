<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    public function profile(){
    	return $this->belongsTo(Profile::class);
    }

    public function document_types(){
    	return $this->belongsTo(DocumentationType::class, 'documentation_type_id');	
    }

    public function files(){
    	return $this->hasOne(DocumentationFile::class, 'document_id');	
    }

}
