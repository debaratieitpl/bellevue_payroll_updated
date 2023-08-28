<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

//Import Modals
use App\Models\Payroll\MonthlyEmployeeOvertime;

class MonthlyEmployeeOvertimeExport implements FromCollection, WithHeadings
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
        $employee_rs = MonthlyEmployeeOvertime::join('employees', 'employees.emp_code', '=', 'monthly_employee_overtimes.emp_code')
            ->select('employees.emp_code', 'employees.old_emp_code', 'employees.emp_fname', 'employees.emp_designation','monthly_employee_overtimes.month_yr', 'monthly_employee_overtimes.last_month_ot_hrs','monthly_employee_overtimes.current_month_ot_hrs','monthly_employee_overtimes.last_month_ot','monthly_employee_overtimes.curr_month_ot','monthly_employee_overtimes.ot_alws')
            ->where('monthly_employee_overtimes.month_yr', $this->date)
            ->where('monthly_employee_overtimes.status', 'process')
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
            'Last Month OT Hrs',
            'Current Month OT Hrs',
            'Last Month OT',
            'Current Month OT',
            'Overtime Allowance',
        ];
    }
}