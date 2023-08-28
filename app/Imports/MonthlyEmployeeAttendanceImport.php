<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MonthlyEmployeeAttendanceImport implements WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        //dd($row);
        \DB::table('process_attendances')
        ->where('employee_code', $row['employee_id'])
        ->where('month_yr', $row['month'])
        ->update([
            'no_of_present' => $row['no_of_present_days'],
            'no_of_days_leave_taken' => $row['no_of_leave_taken'],
            'no_of_days_absent' => $row['no_of_absent_days'],
            'no_of_days_salary' => $row['no_of_salary_days'],
            'no_sal_adjust_days' => $row['no_of_salary_adjustment_days'],
        ]);
    }
}