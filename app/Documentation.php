<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

use DB;

class Documentation extends Model implements Auditable
{
	use \OwenIt\Auditing\Auditable;

    public function profile(){
    	return $this->belongsTo(Profile::class);
    }

    public function document_types(){
    	return $this->belongsTo(DocumentationType::class, 'documentation_type_id');	
    }

    public function files(){
    	return $this->hasOne(DocumentationFile::class, 'document_id');	
    }

    public static function getCountPerDocumentType(){
         return DB::table('documentations')->selectRaw('documentation_types.type, count(*) as counter')
                            ->join('documentation_types', 'documentation_types.id', '=', 'documentations.documentation_type_id')
                            ->groupBy('documentations.documentation_type_id')
                            ->get();

    }

}
