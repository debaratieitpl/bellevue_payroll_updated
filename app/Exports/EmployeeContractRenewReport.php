<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role\Employee;

use DB;

class EmployeeContractRenewReport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $record_rs = Employee::whereDate('contract_renew_date', '>=', now()) // Today and future dates
        ->where('emp_status', '!=', 'TEMPORARY')
        ->where('emp_status', '!=', 'EX-EMPLOYEE')
        ->orderByRaw('contract_renew_date = CURDATE() DESC, contract_renew_date ASC')
        ->get();

        $h = 1;
        $collection_array = array();

        //dd($record_rs[0]);

        if (count($record_rs) != 0) {
            foreach ($record_rs as $record) {

                $collection_array[] = array(
                    'Sl No' => $h,
                    // 'Employee ID'=>$record->emp_code,
                    'Employee Code'=>$record->old_emp_code,
                    'Employee Name'=>$record->salutation.' '.$record->emp_fname.' '.$record->emp_mname.' '.$record->emp_lname,
                    'Father Name'=>$record->emp_father_name,
                    'Department'=>$record->emp_department,
                    'Designation'=>$record->emp_designation,
                    'DOB'=>$record->emp_dob,
                    'DOJ'=>$record->emp_doj,
                    'Increment Date'=>$record->emp_next_increament_date,
                    'Status'=>$record->emp_status,
                    'Mobile No.'=>$record->emp_pr_mobile,
                    'Class'=>ucwords($record->group_name),
                    'PF No.'=>$record->emp_pf_no,
                    'UAN No.'=>$record->emp_uan_no,
                    'PAN No.'=>$record->emp_pan_no,
                    'Bank'=>$record->master_bank_name,
                    'IFSC Code'=>$record->emp_ifsc_code,
                    'Account No.'=>$record->emp_account_no,
                    'emp_pf_inactuals'=>$record->emp_pf_inactuals,
                    'emp_pension'=>$record->emp_pension,
                    'confermation Date'=>$record->emp_from_date,
                    'contract renew date'=>$record->contract_renew_date

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
            // 'Employee ID',
            'Employee Code',
            'Employee Name',
            'Father Name',
            'Department',
            'Designation',
            'DOB',
            'DOJ',
            'Increment Date',
            'Status',
            'Mobile No.',
            'Class',
            'PF No.',
            'UAN No.',
            'PAN No.',
            'Bank',
            'IFSC Code',
            'Account No.',
            'emp_pf_inactuals',
            'emp_pension',
            'confermation Date',
            'contract renew date'

        ];
    }
}
