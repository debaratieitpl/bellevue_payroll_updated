<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

//Import Modals
use App\Models\Attendance\Process_attendance;

class MonthlyEmployeeAttendanceExport implements FromCollection, WithHeadings
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
        $employee_rs = Process_attendance::join('employees', 'employees.emp_code', '=', 'process_attendances.employee_code')
            ->select('employees.emp_code', 'employees.old_emp_code', 'employees.emp_fname', 'employees.emp_designation','process_attendances.month_yr', 'process_attendances.no_of_present','process_attendances.no_of_days_leave_taken','process_attendances.no_of_days_absent','process_attendances.no_of_days_salary','process_attendances.no_sal_adjust_days')
            ->where('process_attendances.month_yr', $this->date)
            ->where('employees.emp_status', '!=', 'TEMPORARY')
            ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
            ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
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
            'No of Present Days',
            'No of Leave Taken',
            'No of Absent Days',
            'No of Salary Days',
            'No of Salary Adjustment Days',
        ];
    }
}