<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;

use DB;

class DepartmentwiseExcel implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //dd();

        $record_rs = Employee::join('employee_pay_structures', 'employee_pay_structures.employee_code', 'employees.emp_code')
                ->select(
                    DB::raw('(COALESCE(basic_pay, 0) + COALESCE(others_alw, 0) + COALESCE(tiff_alw, 0) + COALESCE(hra, 0) + COALESCE(misc_alw, 0) + COALESCE(medical, 0) + COALESCE(conv, 0) + COALESCE(over_time, 0) + COALESCE(leave_inc, 0) + COALESCE(bouns, 0) + COALESCE(hta, 0)) as total_salary'),
                    DB::raw('emp_department as department'),
                )
                ->groupBy('emp_department')
                ->get();

        $h = 1;
        $collection_array = array();

        //dd($record_rs[0]);

        if (count($record_rs) != 0) {
            foreach ($record_rs as $record) {

                $collection_array[] = array(
                    'Sl No' => $h,
                    'Department'=>$record->department,
                    'Total Salary'=>$record->total_salary,
                );
                $h++;
            }

        }
        return collect($collection_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Department',
            'Total Salary',
        ];
    }
}
