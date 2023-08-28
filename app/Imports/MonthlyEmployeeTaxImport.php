<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

//Import Modals
use App\Models\Payroll\MonthlyEmployeeItax;

class MonthlyEmployeeTaxImport implements WithHeadingRow, ToModel
{
    public function model(array $row)
    {
        //dd($row);
        \DB::table('monthly_employee_itaxes')
        ->where('emp_code', $row['employee_id'])
        ->where('month_yr', $row['month'])
        ->update([
            'itax_amount' => $row['income_tax_deduction'],
        ]);
    }
}