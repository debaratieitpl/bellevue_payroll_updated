<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;

use DB;

class DepartmentwiseAllEmpExcel implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $department;
    public function __construct($department)
    {
        $this->department = $department;
    }
    

    public function collection()
    {
        $record_rs =Employee::join('employee_pay_structures', 'employee_pay_structures.employee_code', 'employees.emp_code')
        ->where('emp_department',$this->department)
        ->get(); 

        $h = 1;
        $collection_array = array();

        //dd($record_rs[0]);

        if (count($record_rs) != 0) {
            foreach ($record_rs as $record) {

                $collection_array[] = array(
                    'Sl No' => $h,
                    'Emp_Code'=>$record->old_emp_code,
                    'Name'=>$record->emp_fname.''.$record->emp_lname,
                    'Department'=>$record->emp_department,
                    'Designation'=>$record->emp_department,
                    'Gross Salary'=>$record->basic_pay + $record->hra + $record->tiff_alw + $record->others_alw + $record->misc_alw + $record->medical + $record->conv + $record->conv + $record->over_time + $record->bouns + $record->leave_inc,
                    'Net Salary' =>$record->basic_pay + $record->hra + $record->tiff_alw + $record->others_alw + $record->misc_alw + $record->medical + $record->conv + $record->conv + $record->over_time + $record->bouns + $record->leave_inc - ($record->prof_tax + $record->pf + $record->pf_int + $record->apf + $record->i_tax + $record->insu_prem + $record->pf_loan + $record->esi + $record->adv + $record->hrd + $record->co_op + $record->furniture + $record->misc_ded)
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
            'Emp_Code',
            'Name',
            'Department',
            'Designation',
            'Gross Salary',
            'Net Salary'
        ];
    }
}
