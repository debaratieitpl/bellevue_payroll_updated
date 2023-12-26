<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;

class ImportEmail implements ToModel
{
    public function model(array $row)
    {
        // Assuming that $row[1] is Emp_Code and $row[3] is Email_id from the Excel file
        $empCode = $row[0];
        $empEmail = $row[2];

        // Check if the employee with the given Emp_Code exists and Email_id is null
        $existingEmployee = DB::table('employees')->where('emp_code', $empCode)->whereNull('emp_email')->first();

        if ($existingEmployee) {
            // If the employee exists and Email_id is null, update the emp_email
            DB::table('employees')
                ->where('old_emp_code', $empCode)
                ->update([
                    'emp_email' => $empEmail,
                    // You can update other fields if needed
                ]);
        }

        // Return null as this import is only for updating, not inserting new records
        return null;
    }
}
