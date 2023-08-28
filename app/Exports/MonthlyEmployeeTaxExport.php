<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

//Import Modals
use App\Models\Payroll\MonthlyEmployeeItax;

class MonthlyEmployeeTaxExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $date;
    
    public function __construct($date)
    {
        $this->date = $date;
    }
    
    public function collection()
    {
        $employee_rs = MonthlyEmployeeItax::join('employees', 'employees.emp_code', '=', 'monthly_employee_itaxes.emp_code')
                ->select('employees.emp_code', 'employees.old_emp_code', 'employees.emp_fname', 'employees.emp_designation', 'monthly_employee_itaxes.month_yr','monthly_employee_itaxes.itax_amount')
                ->where('monthly_employee_itaxes.month_yr', $this->date)
                // ->where('monthly_employee_itaxes.status', 'process')
                ->orderBy('employees.emp_fname', 'asc')
                ->get();
            
        return collect($employee_rs);
    }
    
    public function headings(): array
    {
        return [
            'Employee Id',
            'Employee Code',
            'Employee Name',
            'Employee Designation',
            'Month',
            'Income Tax Deduction',
        ];
    }
}