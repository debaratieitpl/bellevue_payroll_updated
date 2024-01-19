<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;

use DB;

class DepartmentNateSalaryExcel implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   
    public function collection()
    {
        $record_rs =Employee::join('employee_pay_structures', 'employee_pay_structures.employee_code', 'employees.emp_code')
        ->select(
            DB::raw('sum(basic_pay + others_alw + tiff_alw + hra + misc_alw + medical + conv + over_time ) as total_salary'),
            DB::raw('sum(pf + apf + i_tax + insu_prem  + furniture ) as total_deduction'),
            DB::raw('(sum(basic_pay + others_alw + tiff_alw + hra + misc_alw + medical + conv + over_time ) - sum(pf + apf + i_tax + insu_prem  + furniture )) as netSalary'),
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
                    'Gross Salary'=>$record->total_salary,
                    'Total Deduction'=>$record->total_deduction,
                    'Net Salary' =>$record->netSalary
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
            'Gross Salary',
            'Total Deduction',
            'Net Salary'
        ];
    }
}
