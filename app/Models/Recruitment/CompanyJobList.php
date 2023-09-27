<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;

class CompanyJobList extends Model
{
    protected $fillable = [
        'soc',
        'department',
        'title',
        'des_job',
    ];
}
