<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MonthlyEmployeeAttendanceImport implements WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        //dd($row['month']);
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

        // \DB::table('process_attendances')
        // ->where('month_yr', $row['month']) // Filter by the current month
        // ->whereNotIn('employee_code', $row['employee_id']) // Exclude employees in the update list
        // ->update([
        //     'no_of_present' => 0,
        //     'no_of_days_leave_taken' => 0,
        //     'no_of_days_absent' => 0,
        //     'no_of_days_salary' => 0,
        //     'no_sal_adjust_days' => 0,
        // ]);
    }
}