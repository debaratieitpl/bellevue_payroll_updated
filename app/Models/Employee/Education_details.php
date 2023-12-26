<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Education_details extends Model
{
    protected $fillable = [
        'institute_name',
        'employee_code',
        'qualification',
        'discipline',
        'university',
        'year_of_passing',
        'percentage',
        'grade',
        'aimage',
    ];
    public $timestamps = true;

}
