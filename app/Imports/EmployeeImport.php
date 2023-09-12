<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EmployeeImport implements WithHeadingRow, ToModel
{
    public function model(array $rows)
    {
        // Prepare an array to hold all the rows to be inserted
        $insertData = [

        ];

        // print_r($row);
        // dd("abbas");
            foreach ($rows as $row) {
                $empCode = $this->generateUniqueEmployeeCode();
                $old_emp_code = $row['employee_code'];
                $rowData = [
                    'emp_code' => $empCode,
                    'old_emp_code' => $old_emp_code,
                    'salutation' => $row['salutation'],
                    'emp_fname' => $row['first_name'],
                    'emp_lname' => $row['last_name'],
                    'emp_mname' => $row['middle_name'],
                    'emp_father_name' => $row['father_name'],
                    'emp_department' => $row['department'],
                    'emp_designation' => $row['designation'],
                    'emp_dob' => $row['dob'],
                    'emp_doj' => $row['doj'],
                    'emp_status' => $row['emp_status'],
                    'status' => 'active',
                    'emp_pr_street_no' => $row['address'],
                    'emp_pr_city' => $row['city'],
                    'emp_pr_state' => $row['state'],
                    'emp_pr_country' => $row['country'],
                    'emp_pr_pincode' => $row['pincode'],
                    'emp_pr_mobile' => $row['mobile_no'],
                    'group_name' => $row['class'],
                    'emp_pf_no' => $row['pf_no'],
                    'emp_uan_no' => $row['uan_no'],
                    'emp_pan_no' => $row['pan_no'],
                    'master_bank_name' => $row['bank'],
                    'emp_ifsc_code' => $row['ifsc_code'],
                    'emp_account_no' => $row['account_no'],
                    'emp_pf_inactuals' => $row['emp_pf_inactuals'],
                    'emp_pension' => $row['emp_pension'],
                ];
                dd($rowData);

               // Add the row data to the insertData array
                $insertData[] = $rowData;
            }

        // Bulk insert all the rows in one query
        \DB::table('employee')->insert($insertData);
    }
    private function generateUniqueEmployeeCode()
    {
        $code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Check if the generated code is unique in the database
        while (\DB::table('employee')->where('emp_code', $code)->exists()) {
            $code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }
}