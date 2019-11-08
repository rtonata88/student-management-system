<?php
namespace App\Imports;

use App\Profile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProfilesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
       foreach($rows as $index => $row){
       		if ($index > 0){ //skip the heading row and 
            
       		}
       }
    }
}