<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Role\Employee;

class SampleEmployeeExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
            
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $record_rs = Employee::select('employees.*', 'employee_pay_structures.*', 'group_name_details.group_name', 'bank_masters.master_bank_name')
                        ->join('employee_pay_structures', 'employees.emp_code', '=', 'employee_pay_structures.employee_code')
                        ->join('group_name_details', 'employees.emp_group_name', '=', 'group_name_details.id')
                        ->leftJoin('bank_masters', 'employees.emp_bank_name', '=', 'bank_masters.id')
                        ->where('employees.emp_status', '!=', 'EX-EMPLOYEE')
                        ->where('employees.emp_status', '!=', 'EX- EMPLOYEE')
                        ->where('employees.emp_status', '!=', 'TEMPORARY')
                        ->where('employees.status', '=', 'active')
                        ->orderByRaw('cast(employees.old_emp_code as unsigned)', 'asc')
                        ->groupBy('employees.emp_code')
                        ->limit(4)
                        ->get();

        $h = 1;
        $collection_array = array();
        
        //dd($record_rs[0]);

        if (count($record_rs) != 0) {
            foreach ($record_rs as $record) {

                $collection_array[] = array(
                    'Employee Code'=>$record->old_emp_code,
                    'Salutation'=>$record->salutation,
                    'First Name'=>$record->emp_fname,
                    'Last Name'=>$record->emp_lname,
                    'Middle Name'=>$record->emp_mname,
                    'Father Name'=>$record->emp_father_name,
                    'Department'=>$record->emp_department,
                    'Designation'=>$record->emp_designation,
                    'DOB'=>$record->emp_dob,
                    'DOJ'=>$record->emp_doj,
                    'EMP Status'=>$record->emp_status,
                    'Status'=>$record->status,
                    'Address'=>$record->emp_pr_street_no,
                    'City'=>$record->emp_pr_city,
                    'State'=>$record->emp_pr_state,
                    'Country'=>$record->emp_pr_country,
                    'Pincode'=>$record->emp_pr_pincode,
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
                    'Basic Pay'=>$record->basic_pay,
                    'HRA'=>$record->hra,
                    'HRA Type'=>$record->hra_type,
                    'Tiff. Alw.'=>$record->tiff_alw,
                    'Tiff. Alw Type.'=>$record->tiff_alw_type,
                    'Conv. Alw.'=>$record->conv,
                    'Conv. Alw Type'=>$record->conv_type,
                    'Med. Alw.'=>$record->medical,
                    'Med. Alw Type'=>$record->medical_type,
                    'Misc. Alw.'=>$record->misc_alw,
                    'Misc. Alw Type.'=>$record->misc_alw_type,
                    'Other. Alw.'=>$record->others_alw,
                    'Other. Alw Type.'=>$record->others_alw_type,
                    'PTax'=>$record->prof_tax,
                    'PTax Type'=>$record->prof_tax_type,
                    'Coop. Ded.'=>$record->co_op,
                    'Coop. Ded Type.'=>$record->co_op_type,
                    'Insurance Prem. Ded.'=>$record->insu_prem,
                    'Insurance Prem. Ded Type.'=>$record->insu_prem_type,

                );
                $h++;
            }

        }
        return collect($collection_array);
    }

    public function headings(): array
    {
        return [
            'Employee Code',
            'Salutation',
            'First Name',
            'Last Name',
            'Middle Name',
            'Father Name',
            'Department',
            'Designation',
            'DOB',
            'DOJ',
            'EMP Status',
            'Status',
            'Address',
            'City',
            'State',
            'Country',
            'Pincode',
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
            'Basic Pay',
            'HRA',
            'HRA Type',
            'Tiff. Alw.',
            'Tiff. Alw Type.',
            'Conv. Alw.',
            'Conv. Alw Type.',
            'Med. Alw.',
            'Med. Alw Type.',
            'Misc. Alw.',
            'Misc. Alw Type.',
            'Other. Alw.',
            'Other. Alw Type.',
            'PTax',
            'PTax Type',
            'Coop. Ded.',
            'Coop. Ded Type.',
            'Insurance Prem. Ded.',
            'Insurance Prem. Ded Type.',

        ];
    }
}
