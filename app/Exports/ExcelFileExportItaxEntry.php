<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;
use App\Models\Payroll\Payroll_detail;
use DB;

class ExcelFileExportItaxEntry implements FromCollection, WithHeadings
{
    private $month_yr;
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month_yr)
    {
        
        $this->month_yr = $month_yr;
        
    }
    public function collection()
    {
        $employee_rs = Employee::join('monthly_employee_itaxes', 'monthly_employee_itaxes.emp_code', '=', 'employees.emp_code')
        ->select(
            'employees.old_emp_code',
            'employees.emp_code',
            'monthly_employee_itaxes.*',
            'employees.salutation',
            'employees.emp_fname',
            'employees.emp_mname',
            'employees.emp_lname'
        )
        ->where('monthly_employee_itaxes.month_yr', '=', $this->month_yr)
        ->orderBy('employees.old_emp_code', 'asc')
        ->get();

        $h = 1;
        $customer_array = array();
        
        $total_itax_amount=0;

        if (count($employee_rs) != 0) {
            foreach ($employee_rs as $record) {
                $total_itax_amount=$total_itax_amount+$record->itax_amount;

                $customer_array[] = array(
                    'Sl No' => $h,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Status'=>ucwords($record->status),
                    'Income Tax Deduction'=>number_format(round($record->itax_amount, 1), 2),
                );
                $h++;
            }
            $customer_array[] = array(
                'Sl No' => 'Grand',
                'Employee Code'=>'Total',
                'Employee Name'=>'',
                'Status'=>'',
                'Income Tax Deduction'=>number_format(round($total_itax_amount, 1), 2),
    
            );

        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Employee Code',
            'Employee Name',
            'Status',
            'Income Tax Deduction',
        ];
    }
}
