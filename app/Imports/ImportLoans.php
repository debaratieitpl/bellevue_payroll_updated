<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow; 
use App\Models\Role\Employee; 
use App\Models\Loan\Loan;

class ImportLoans implements ToCollection,WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $numericDate = $row[3];
            $timestamp = ($numericDate - 25569) * 86400;
            $date = date('Y-m-d', $timestamp);
            $maxid=Loan::max('id');
            if($maxid==null){
                $maxid=1;
            }else{
                $maxid=$maxid+1;
            }
            $loan_id='L'.str_pad($maxid,'3','0',STR_PAD_LEFT);
            $empCode = $row[1];
            $employee = Employee::where('old_emp_code', $empCode)->first();
            if ($employee) {
                DB::table('loans')->insert([
                    'loan_id' => $loan_id,
                    'emp_code' => $employee->emp_code,
                    'loan_type' => $row[2],
                    'start_month' => $date,
                    'loan_amount' => $row[4],
                    'installment_amount' => $row[5],
                    'deduction' => $row[6],
                ]);
            }
        }
    }
}
