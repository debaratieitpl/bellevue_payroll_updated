<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow; 
use DateTime;

class ImportEmployee implements ToModel, WithStartRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        // dd($row);
         $employeeId = $this->generateUniqueEmployeeCode();
         DB::table('employees')->insert([
            'emp_code' => $employeeId,
            'old_emp_code' => $row[0],
            'salutation' => $row[1],
            'emp_fname' => $row[2],
            'emp_lname' => $row[3],
            'emp_mname' => $row[4],
            'emp_father_name' => $row[5],
            'emp_department' => $row[6],
            'emp_designation' => $row[7],
            'emp_dob' => $row[8],
            'emp_doj' => $row[9],
            'emp_status' => $row[10],
            'status' => $row[11],
            'emp_pr_street_no' => $row[12],
            'emp_pr_city' => $row[13],
            'emp_pr_state' => $row[14],
            'emp_pr_country' => $row[15],
            'emp_pr_pincode' => $row[16],
            'emp_pr_mobile' => $row[17],
            'emp_group_name' => $row[18],
            'emp_pf_no' => $row[19],
            'emp_uan_no' => $row[20],
            'emp_pan_no' => $row[21],
            'emp_bank_name' => $row[22],
            'emp_ifsc_code' => $row[23],
            'emp_account_no' => isset($row[24]) ? $row[24] : null,
            'emp_pf_inactuals' => isset($row[25]) ? $row[25] : 'Y',
            'emp_pension' => isset($row[26]) ? $row[26] : 'Y',
        ]);

        DB::table('employee_pay_structures')->insert([
            'employee_code' => $employeeId,
            'basic_pay'     => $row[27],
            'hra'     => $row[28],
            'hra_type'     => $row[29],
            'tiff_alw'     => $row[30],
            'tiff_alw_type'     => $row[31],
            'conv'     => $row[32],
            'conv_type'     => $row[33],
            'medical'     => $row[34],
            'medical_type'     => $row[35],
            'misc_alw'     => $row[36],
            'misc_alw_type'     => $row[37],
            'others_alw'     => $row[38],
            'others_alw_type'     => $row[39],
            'prof_tax'     => $row[40],
            'prof_tax_type'     => $row[41],
            'co_op'     => $row[42],
            'co_op_type'     => $row[43],
            'insu_prem'     => $row[44],
            'insu_prem_type'     => $row[45],

        ]);
        return null;
    }
    private function generateUniqueEmployeeCode()
    {
        $code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        while (\DB::table('employees')->where('emp_code', $code)->exists()) {
            $code = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }
   

}
