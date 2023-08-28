<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MonthlyEmployeeOvertimeImport implements WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        \DB::table('monthly_employee_overtimes')
        ->where('emp_code', $row['employee_id'])
        ->where('month_yr', $row['month'])
        ->update([
            'last_month_ot_hrs' => $row['last_month_ot_hrs'],
            'current_month_ot_hrs' => $row['current_month_ot_hrs'],
            'last_month_ot' => $row['last_month_ot'],
            'curr_month_ot' => $row['current_month_ot'],
            'ot_alws' => $row['overtime_allowance'],
        ]);
    }
}