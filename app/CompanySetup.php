<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySetup extends Model
{
    protected $fillable = ['company_name','address1','address2','address3', 'address4', 'contact_number', 'fax_number', 'email', 'email', 'logo'];
}
