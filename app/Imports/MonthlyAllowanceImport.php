<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MonthlyAllowanceImport implements WithHeadingRow, ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //dd($row);
        \DB::table('monthly_employee_allowances')
        ->where('emp_code', $row['employee_code'])
        ->where('month_yr', $row['month_yr'])
        ->update([
            'no_days_tiffalw' => $row['no_of_tiffin_alw_days'],
            'pay_structure_tiff_alw' => $row['ent_tiffin_allowance'],
            'tiffin_alw' => $row['tiffin_allowance'],
            'no_days_convalw' => $row['no_of_conv_alw_days'],
            'pay_structure_conv_alw' => $row['ent_conv_allowance'],
            'convence_alw' => $row['conv_allowance'],
            'no_days_miscalw' => $row['no_of_mics_alw_days'],
            'pay_structure_misc_alw' => $row['ent_mics_allowance'],
            'misc_alw' => $row['mics_allowance'],
            'extra_misc_alw' => $row['extra_mics_allowance'],
            'no_days_otheralw' => $row['ent_other_alw_days'],
            'pay_structure_other_alw' => $row['ent_other_allowance'],
            'other_alw' => $row['other_allowance'],
        ]);
    }
}
