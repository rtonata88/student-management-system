<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportRequest extends Model
{
    use HasFactory;

    protected $fillable = ['report_type',
                            'request_datetime',
                            'document_path',
                            'status',
                            'requested_by'];
}
